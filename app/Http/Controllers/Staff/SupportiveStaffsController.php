<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Staff\Staff;
use App\Models\Staff\SupportiveStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SupportiveStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $supportiveStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->supportiveStaffs as $supportiveStaff) {
                            $supportiveStaffs[] = $supportiveStaff;
                        }
                    }
                }
            }
        } else {
            $supportiveStaffs = SupportiveStaff::all();
        }

        $data = array(
            'staffs' => $supportiveStaffs,
            'page_name' => 'staff.supportive.list'
        );

        // return $data['staffs'][0];
        return view('staff.supportive.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => SupportiveStaff::getEnum("StaffRanks"),
            'page_name' => 'staff.supportive.create'
        );
        return view('staff.supportive.create')->with($data);
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
            'supportive_staff_rank' => 'required',
        ]);

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
        $staff->is_expatriate = $request->has('expatriate');
        $staff->is_from_other_region = $request->has('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $supportiveStaff = new SupportiveStaff;
        $supportiveStaff->staffRank = $request->input('supportive_staff_rank');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
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

        $college->supportiveStaffs()->save($supportiveStaff);
        $supportiveStaff = SupportiveStaff::find($supportiveStaff->id);
        $supportiveStaff->general()->save($staff);

        return redirect('/staff/supportive');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => SupportiveStaff::with('general')->find($id),
            'page_name' => 'staff.supportive.details'
        );
        return view('staff.supportive.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => SupportiveStaff::with('general')->find($id),
            'page_name' => 'staff.supportive.edit'
        );
        return view('staff.supportive.edit')->with($data);
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
            'supportive_staff_rank' => 'required'

        ]);

        $supportiveStaff = SupportiveStaff::find($id);
        $supportiveStaff->staffRank = $request->input('supportive_staff_rank');

        $staff = new $supportiveStaff->general;
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
        $staff->is_expatriate = $request->has('expatriate');
        $staff->is_from_other_region = $request->has('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
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

        $college->supportiveStaffs()->save($supportiveStaff);
        $supportiveStaff = SupportiveStaff::find($supportiveStaff->id);
        $supportiveStaff->general()->save($staff);

        return redirect('/staff/supportive');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $administrativeStaff = AdministrativeStaff::find($id);
        $staff = $administrativeStaff->general;
        $administrativeStaff->delete();
        $staff->delete();
        return redirect('/staff/administrative');
    }
}
