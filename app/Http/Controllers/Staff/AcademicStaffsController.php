<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\JobTitle;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffLeave;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AcademicStaffsController extends Controller
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);


        $academicStaffs = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                foreach ($department->academicStaffs as $academicStaff)
                    $academicStaffs[] = $academicStaff;
        }

        $data = array(
            'staffs' => $academicStaffs,
            'departments' => $collegeDeps,

            'selected_department' => $requestedDepartment,

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
        $user->authorizeRoles('Department Admin');

        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => AcademicStaff::getEnum("StaffRanks"),
            'job_titles' => JobTitle::where('staff_type', 'Academic')->get(),
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
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required|regex:/(09)[0-9]{8}/',
            'nationality' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'field_of_study' => 'required',
            'job_title' => 'required',
            'teaching_load' => 'required|numeric|between:0,100'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'NONE'); //?
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);
        $staff = new Staff;
        HierarchyService::populateStaff($request, $staff);

        $academicStaff = new AcademicStaff;
        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->staff_leave_id = null;
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->hdp_trained = $request->has('hdp_trained');

        $academicStaff->job_title_id = $request->input('job_title');
        $department->academicStaffs()->save($academicStaff);
        $academicStaff = AcademicStaff::find($academicStaff->id);
        $academicStaff->general()->save($staff);

        return redirect('/staff/academic')->with('success', 'Successfully Added Academic Staff');
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
        $user->authorizeRoles('Department Admin');

        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::find($id),
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
        $user->authorizeRoles('Department Admin');

        $data = array(
            //'staff' => AcademicStaff::with('general')->find($id)
            'staff' => AcademicStaff::find($id),
            'staff_leave_types' => StaffLeave::getEnum('LeaveTypes'),
            'staff_scholarship_types' => StaffLeave::getEnum('ScholarshipTypes'),
            'job_titles' => JobTitle::where('staff_type', 'Academic')->get(),
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
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required|regex:/(09)[0-9]{8}/',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'field_of_study' => 'required',
            'teaching_load' => 'required|numeric|between:0,100'
        ]);
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

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
                $staffLeave = StaffLeave::find($academicStaff->staff_leave_id);
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
            $item = StaffLeave::find($academicStaff->staff_leave_id);
            if ($item != null) {
                $item->delete();
            }
            $academicStaff->staff_leave_id = null;
        }

        $academicStaff->field_of_study = $request->input('field_of_study');
        $academicStaff->teaching_load = $request->input('teaching_load');
        $academicStaff->overload_remark = $request->input('overload_remark');
        $academicStaff->hdp_trained = $request->has('hdp_trained');
        $academicStaff->job_title_id = $request->input('job_title');
        $academicStaff->overload_remark = $request->input('overload_remark') == null ? " " : $request->input('overload_remark');
        $academicStaff->save();

        $staff = $academicStaff->general;
        HierarchyService::populateStaff($request, $staff);
        $academicStaff->general()->save($staff);

        return redirect('/staff/academic')->with('primary', 'Successfully Updated');
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
        $item = AcademicStaff::find($id);
        $item->delete();
        return redirect('/staff/academic')->with('primary', 'Successfully Deleted');
    }
}
