<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\TechnicalStaff;
use App\Models\Staff\IctStaff;
use App\Models\Staff\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TechnicalStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

        $technicalStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->ictStaffs as $technicalStaff) {
                            $technicalStaffs[] = $technicalStaff;
                        }
                    }
                }
            }
        } else {
            $technicalStaffs = IctStaff::all();
        }
        $data = array(
            'staffs' => $technicalStaffs,
            'page_name' => 'staff.technical.list'
        );
        return view('staff.technical.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'employment_types' => Staff::getEnum("employment_type"),
            'dedications' => Staff::getEnum("dedication"),
            'academic_levels' => Staff::getEnum("academic_levels"),
            'staff_ranks' => TechnicalStaff::getEnum("staff_rank"),
            'page_name' => 'staff.technical.create'
        );
        return view('staff.technical.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required',
            'service_year' => 'required',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'expatriate' => 'nullable',
            'technical_staff_rank' => 'required',
        ]);

        if ($request->get('expatriate') == null) {
            $expatriate = 0;
        } else {
            $expatriate = 1;
        }

        $staff = new Staff;
        $staff->name = $request->input('name');
        $staff->birth_date = $request->input('birth_date');
        $staff->sex = $request->input('sex');
        $staff->phone_number = $request->input('phone_number');
        $staff->nationality = $request->input('nationality');
        $staff->job_title = $request->input('job_title');
        $staff->salary = $request->input('salary');
        $staff->service_year = $request->input('service_year');
        $staff->employment_type = $request->input('employment_type');
        $staff->dedication = $request->input('dedication');
        $staff->academic_level = $request->input('academic_level');
        $staff->is_expatriate = $expatriate;
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $technicalStaff = new TechnicalStaff;
        $technicalStaff->staff_rank = $request->input('technical_staff_rank');

        $user = Auth::user();
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->technicalStaff()->save($technicalStaff);
        $technicalStaff = TechnicalStaff::find($technicalStaff->id);
        $technicalStaff->general()->save($staff);

        return redirect('/staff/technical');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = array(
            'staff' => TechnicalStaff::with('general')->find($id),
            'page_name' => 'staff.technical.details'
        );
        return view('staff.technical.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = array(
            'staff' => TechnicalStaff::with('general')->find($id),
            'page_name' => 'staff.technical.edit'
        );
        return view('staff.technical.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required',
            'service_year' => 'required',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'expatriate' => 'required',
            'technical_staff_rank' => 'required'

        ]);

        $technicalStaff = TechnicalStaff::find($id);

        $technicalStaff->staffRank = $request->input('technical_staff_rank');
        $technicalStaff->institution_id = 0;

        $staff = $technicalStaff->general;
        $staff->name = $request->input('name');
        $staff->birth_date = $request->input('birth_date');
        $staff->sex = $request->input('sex');
        $staff->phone_number = $request->input('phone_number');
        $staff->nationality = $request->input('nationality');
        $staff->job_title = $request->input('job_title');
        $staff->salary = $request->input('salary');
        $staff->service_year = $request->input('service_year');
        $staff->employment_type = $request->input('employment_type');
        $staff->dedication = $request->input('dedication');
        $staff->academic_level = $request->input('academic_level');
        $staff->is_expatriate = $request->input('expatriate');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $technicalStaff->save();

        $technicalStaff->general()->save($staff);

        return redirect('/staff/technical');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $technicalStaff = TechnicalStaff::find($id);
        $staff = $technicalStaff->general;
        $technicalStaff->delete();
        $staff->delete();
        return redirect('/staff/technical');
    }
}
