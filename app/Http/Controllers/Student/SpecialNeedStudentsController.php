<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Student\DormitoryService;
use App\Models\Student\SpecialNeedStudent;
use App\Models\Student\Student;
use App\Models\Student\StudentService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialNeedStudentsController extends Controller
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

        $students = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->specialNeedStudents as $student)
                        $students[] = $student;
            } else {
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->specialNeedStudents as $student)
                            $students[] = $student;
            }
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);

        $data = array(
            'students' => $students,
            'departments' => $collegeDeps,
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'students.special_need.index'
        );
        // return SpecialNeedStudent::info()->get();
        return view("students.special_need.index")->with($data);
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

        $data = array(
            'departments' => DepartmentName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'food_service_types' => StudentService::getEnum("FoodServiceTypes"),
            'dormitory_service_types' => DormitoryService::getEnum("DormitoryServiceTypes"),
            'disabilitys' => SpecialNeedStudent::getEnum("Disabilitys"),
            'student_types' => Student::getEnum('StudentTypes'),
            'page_name' => 'students.special_need.create'
        );
        return view("students.special_need.create")->with($data);
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
            'student_id' => 'required',
            'student_type' => 'required',
        ]);

        if ($request->input("dormitory_service_type") == "In Kind") {
            $this->validate($request, [
                'block_number' => 'required',
                'room_number' => 'required'
            ]);
        }

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = $request->input('education_level');
        $educationProgram = $request->input('program');
        $yearLevel = $request->input('year_level');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $dormitoryService = new DormitoryService;
        $studentService = new StudentService;
        $student = new Student;
        HierarchyService::populateStudent($request, $dormitoryService, $studentService, $student);

        $specialNeedStudent = new SpecialNeedStudent;
        $specialNeedStudent->disability = $request->input("disability_type");

        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->specialNeedStudents()->save($specialNeedStudent);
        $specialNeedStudent = SpecialNeedStudent::find($specialNeedStudent->id);
        $student->student_service_id = null;
        $specialNeedStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/special-need")->with('success', 'Successfully Added Special Need Student');
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
            'student' => SpecialNeedStudent::find($id),
            'page_name' => 'students.special_need.details'
        );
        return view("students.special_need.details")->with($data);
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
            'student' => SpecialNeedStudent::find($id),
            'colleges' => CollegeName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'students.special_need.edit'
        );
        return view("students.special_need.edit")->with($data);
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
            'student_id' => 'required',
            'student_type' => 'required',
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
        $specialNeedStudent = SpecialNeedStudent::find($id);

        $dormitoryService = $specialNeedStudent->general->studentService->dormitoryService;
        $studentService = $specialNeedStudent->general->studentService;
        $student = $specialNeedStudent->general;
        HierarchyService::populateStudent($request, $dormitoryService, $studentService, $student);
        $specialNeedStudent->disability = $request->input("disability_type");

        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->specialNeedStudents()->save($specialNeedStudent);
        $specialNeedStudent = SpecialNeedStudent::find($specialNeedStudent->id);
        $student->student_service_id = null;
        $specialNeedStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/special-need")->with('primary', 'Successfully Updated');
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
        $item = SpecialNeedStudent::find($id);
        $item->delete();
        return redirect('/student/special-need')->with('primary', 'Successfully Deleted');
    }
}
