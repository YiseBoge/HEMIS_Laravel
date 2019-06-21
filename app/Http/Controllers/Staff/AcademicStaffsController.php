<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffLeave;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AcademicStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $academicStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $user->collegeName->id) {
                        foreach ($college->departments as $department) {
                            if ($department->departmentName->id == $user->departmentName->id) {
                                foreach ($department->academicStaffs as $academicStaff) {
                                    $academicStaffs[] = $academicStaff;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $academicStaffs = AcademicStaff::all();
        }

        $data = array(
            'staffs' => $academicStaffs,
            'page_name' => 'staff.academic.list'
        );
        //return AcademicStaff::with('general')->get();
        return view('staff.academic.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => AcademicStaff::getEnum("StaffRanks"),
            'page_name' => 'staff.academic.create'
        );
        return view('staff.academic.create')->with($data);
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
            'field_of_study' => 'required',
            'academic_staff_rank' => 'required',
            'teaching_load' => 'required'
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

        $academicStaff = new AcademicStaff;
        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->staffRank = $request->input('academic_staff_rank');
        $academicStaff->staff_leave_id = 0;
        $academicStaff->overload_remark = $request->input('overload_remark') == null ? " " : $request->input('overload_remark');

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

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

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->academicStaffs()->save($academicStaff);
        $academicStaff = AcademicStaff::find($academicStaff->id);
        $academicStaff->general()->save($staff);

        return redirect('/staff/academic');
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::info()->find($id),
            'page_name' => 'staff.academic.details'
        );
        return view('staff.academic.details')->with($data);
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
        $user->authorizeRoles('Department Admin');

        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::info()->find($id),
            'staff_leave_types' => StaffLeave::getEnum('LeaveTypes'),
            'staff_scholarship_types' => StaffLeave::getEnum('ScholarshipTypes'),
            'page_name' => 'staff.academic.edit'
        );
        return view('staff.academic.edit')->with($data);
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
            'field_of_study' => 'required',
            'academic_staff_rank' => 'required',
            'teaching_load' => 'required',

        ]);
        $academicStaff = AcademicStaff::find($id);
        if ($request->input('status') == "onLeave") {
            $this->validate($request, [
                'leave_type' => 'required',
                'leave_country' => 'required',
                'leave_institution' => 'required',
                'leave_status' => 'required',
                'leave_rank' => 'required',
                'leave_scholarship' => 'required'
            ]);
            if ($academicStaff->staff_leave_id == 0) {
                $staffLeave = new StaffLeave;
            } else {
                $staffLeave = StaffLeave::Find($academicStaff->staff_leave_id);
            }

            $staffLeave->leave_type = $request->input('leave_type');
            $staffLeave->institution = $request->input('leave_institution');
            $staffLeave->country_of_study = $request->input('leave_country');
            $staffLeave->rank_of_study = $request->input('leave_rank');
            $staffLeave->status_of_study = $request->input('leave_status');
            $staffLeave->scholarship_type = $request->input('leave_scholarship');
            $staffLeave->save();
            $staffLeave = StaffLeave::find($staffLeave->id);
            $staffLeave->academicStaff()->save($academicStaff);

        } else {
            //Handle On duty
        }
        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->staffRank = $request->input('academic_staff_rank');
        $academicStaff->overload_remark = $request->input('overload_remark') == null ? " " : $request->input('overload_remark');

        $staff = $academicStaff->general;
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

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
            $college->education_program = 'None';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => 'None',
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'None';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->academicStaffs()->save($academicStaff);
        $academicStaff->save();
        $academicStaff->general()->save($staff);

        return redirect('/staff/academic');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Department Admin');

        $academicStaff = AcademicStaff::find($id);
        $staff = $academicStaff->general;
        $academicStaff->delete();
        $staff->delete();
        return redirect('/staff/academic');
    }
}
