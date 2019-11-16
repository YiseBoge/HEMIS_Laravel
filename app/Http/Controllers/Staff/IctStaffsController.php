<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Staff\IctStaff;
use App\Models\Staff\IctStaffType;
use App\Models\Staff\Staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class IctStaffsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'College Super Admin']);

        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $ictStaffs = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->ictStaffs as $ictStaff)
                    $ictStaffs[] = $ictStaff;

        $data = array(
            'staffs' => $ictStaffs,
            'page_name' => 'staff.ict.list'
        );
        return view('staff.ict.list')->with($data);
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
            'staff_ranks' => IctStaff::getEnum("StaffRanks"),
            'ict_types' => IctStaffType::all(),
            'page_name' => 'staff.ict.create'
        );
        return view('staff.ict.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'ict_staff_rank' => 'required',
            'ict_type' => 'required'
        ]);

        $ictStaff = new IctStaff();

        $ictStaff->staffRank = $request->input('ict_staff_rank');
        $ictStaff->ict_staff_type_id = $request->input('ict_type');

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


        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $institution = $user->institution();
        $bandName = $user->bandName;

        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = null;
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
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->ictStaffs()->save($ictStaff);
        $ictStaff = IctStaff::find($ictStaff->id);
        $ictStaff->general()->save($staff);

        return redirect('/staff/ict')->with('success', 'Successfully Added ICT Staff');
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
            'staff' => IctStaff::with('general')->find($id),
            'page_name' => 'staff.ict.details'
        );
        return view('staff.ict.details')->with($data);
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => IctStaff::with('general')->find($id),
            'page_name' => 'staff.ict.edit'

        );
        return view('staff.ict.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'ict_staff_rank' => 'required',
            'ict_type' => 'required'
        ]);

        $ictStaff = IctStaff::find($id);

        $ictStaff->staffRank = $request->input('ict_staff_rank');
        $ictStaff->institution_id = null;

        $staff = $ictStaff->general;
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
        $staff->is_from_other_region = $request->input('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');


        $ictStaff->general()->save($staff);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;


        $ictStaff->save();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        $college->ictStaffs()->save($staff);
                    }
                }
            }
        }

        return redirect('/staff/ict')->with('primary', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = IctStaff::find($id);
        $item->delete();
        return redirect('/staff/ict')->with('primary', 'Successfully Deleted');
    }
}
