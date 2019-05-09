<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Staff\Staff;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\StaffLeave;

class AcademicStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array(
            'staffs' => AcademicStaff::with('general')->get(),
            'page_name' => 'academic.list'
        );
        return view('staff.academic.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => AcademicStaff::getEnum("StaffRanks"),
            'page_name' => 'academic.create'
        );
        return view('staff.academic.create')->with($data);
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
            'expatriate' => 'boolean|nullable',
            'field_of_study' => 'required',
            'academic_staff_rank' => 'required',
            'teaching_load' => 'required'
        ]);

        if($request->get('expatriate') == null){
            $expatriate = 0;
        }
        else{
            $expatriate = request('expatriate');
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

        $academicStaff = new AcademicStaff;
        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->staffRank = $request->input('academic_staff_rank');
        $academicStaff->staff_leave_id = 0;
        $academicStaff->institution_id = 0;
        $academicStaff->overload_remark = $request->input('overload_remark') == null ? " " : $request->input('overload_remark');

        $academicStaff->save();

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
        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::info()->find($id),
            'page_name' => 'academic.details'
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
        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::info()->find($id),
            'staff_leave_types' => StaffLeave::getEnum('LeaveTypes'),
            'staff_scholarship_types' => StaffLeave::getEnum('ScholarshipTypes'),
            'page_name' => 'academic.edit'
        );
        return view('staff.academic.edit')->with($data);
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
            'field_of_study' => 'required',
            'academic_staff_rank' => 'required',
            'teaching_load' => 'required',
            
        ]);

        $academicStaff = AcademicStaff::find($id);

        if($request->input('status') == "onLeave"){
            $this->validate($request, [
                'leave_type' => 'required',
                'leave_country' => 'required',
                'leave_institution' => 'required',
                'leave_status' => 'required',
                'leave_rank' => 'required',
                'leave_scholarship' => 'required'
            ]);

            if($academicStaff->staff_leave_id == 0){
                $staffLeave = new StaffLeave;
            }else{
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
            
        }

        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->staffRank = $request->input('academic_staff_rank');
        $academicStaff->institution_id = 0;
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
        $staff->is_expatriate = $request->input('expatriate');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');        

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
        $academicStaff = AcademicStaff::find($id);
        $staff = $academicStaff->general;
        $academicStaff->delete();
        $staff->delete();
        return redirect('/staff/academic');
    }
}
