<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Institution\AgeEnrollment;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AgeEnrollmentsController extends Controller
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

        $requestedProgram = request()->query('program', 'Regular');
        $requestedLevel = request()->query('education_level', 'Undergraduate');
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);


        $enrollments = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->ageEnrollments as $enrollment){
                        $enrollments[] = $enrollment;
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
            } else
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->ageEnrollments as $enrollment){
                            $enrollments[] = $enrollment;
                            $total += $enrollment->male_students_number + $enrollment->female_students_number;
                        }
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);

        $data = [
            'enrollment_info' => $enrollments,
            'departments' => $collegeDeps,
            'age_range' => AgeEnrollment::getEnum('Ages'),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => Department::getEnum('YearLevels'),
            'total' => $total,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'enrollment.age_enrollment.index'];

        return view('enrollment.age_enrollment.index')->with($data);
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

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum('YearLevels');
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = ['enrollment_info' => AgeEnrollment::all(),
            'age_range' => AgeEnrollment::getEnum('Ages'),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'page_name' => 'enrollment.age_enrollment.create'];
        return view('enrollment.age_enrollment.create')->with($data);
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
            'number_of_males' => 'required|numeric|between:0,1000000000',
            'number_of_females' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'None');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $age_enrollment = new AgeEnrollment();
        $age_enrollment->male_students_number = $request->input('number_of_males');
        $age_enrollment->female_students_number = $request->input('number_of_females');
        $age_enrollment->age = $request->input('age_range');

        $age_enrollment->department_id = $department->id;

        if ($age_enrollment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $age_enrollment->save();

        return redirect('enrollment/age-enrollment')->with('success', 'Successfully Added Age Enrollment');
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        return redirect('enrollment/age-enrollment');
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $ageEnrollment = AgeEnrollment::find($id);
        $department = $ageEnrollment->department()->first();
        $college = $department->college()->first();

        $data = [
            'id' => $id,
            'age_range' => $ageEnrollment->age,
            'male_students_number' => $ageEnrollment->male_students_number,
            'female_students_number' => $ageEnrollment->female_students_number,
            'program' => $college->education_program,
            'education_level' => $college->education_level,
            'year_level' => $department->year_level,
            'page_name' => 'enrollment.age_enrollment.edit'];

        return view('enrollment.age_enrollment.edit')->with($data);
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
            'number_of_males' => 'required|numeric|between:0,1000000000',
            'number_of_females' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $ageEnrollment = AgeEnrollment::find($id);

        $ageEnrollment->male_students_number = $request->input("number_of_males");
        $ageEnrollment->female_students_number = $request->input("number_of_females");
        $ageEnrollment->approval_status = "Pending";

        $ageEnrollment->save();

        return redirect('enrollment/age-enrollment')->with('primary', 'Successfully Updated');
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
        $item = AgeEnrollment::find($id);
        $item->delete();
        return redirect('/enrollment/age-enrollment')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $enrollment = AgeEnrollment::find($id);
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->ageEnrollments);
                        }
                    }
                }
            }
        }
        return redirect("/enrollment/age-enrollment?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
