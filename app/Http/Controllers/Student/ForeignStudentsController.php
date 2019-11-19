<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Student\DormitoryService;
use App\Models\Student\ForeignStudent;
use App\Models\Student\Student;
use App\Models\Student\StudentService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ForeignStudentsController extends Controller
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
                    foreach ($department->foreignStudents as $student)
                        $students[] = $student;
            } else
                if ($college->education_level == $requestedLevel && $college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->foreignStudents as $student)
                            $students[] = $student;
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum('YearLevels');
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = array(
            'students' => $students,
            'departments' => $collegeDeps,
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            'page_name' => 'students.foreign.list'
        );
        return view("students.foreign.index")->with($data);
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
            'student_types' => Student::getEnum("student_type"),
            'page_name' => 'students.foreign.create'
        );
        return view("students.foreign.create")->with($data);
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
            'student_id' => 'required',
            'nationality' => 'required',
            'years_in_ethiopia' => 'required|numeric|between:0,100'
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

        $foreignerStudent = new ForeignStudent;
        $foreignerStudent->nationality = $request->input("nationality");
        $foreignerStudent->years_in_ethiopia = $request->input("years_in_ethiopia");


        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->foreignStudents()->save($foreignerStudent);
        $foreignerStudent = ForeignStudent::find($foreignerStudent->id);
        $student->student_service_id = null;
        $foreignerStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/foreign")->with('success', 'Successfully Added Foreign Student');
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
            'student' => ForeignStudent::find($id),
            'page_name' => 'students.foreign.details'
        );
        return view("students.foreign.details")->with($data);
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
            'student' => ForeignStudent::find($id),
            'colleges' => CollegeName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'students.foreign.edit'
        );
        return view("students.foreign.edit")->with($data);
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
            'student_id' => 'required',
            'nationality' => 'required',
            'years_in_ethiopia' => 'required|numeric|between:0,100'
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
        $foreignerStudent = ForeignStudent::find($id);

        $dormitoryService = $foreignerStudent->general->studentService->dormitoryService;
        $studentService = $foreignerStudent->general->studentService;
        $student = $foreignerStudent->general;
        HierarchyService::populateStudent($request, $dormitoryService, $studentService, $student);

        $foreignerStudent->nationality = $request->input("nationality");
        $foreignerStudent->years_in_ethiopia = $request->input("years_in_ethiopia");

        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->ForeignStudents()->save($foreignerStudent);
        $foreignerStudent = ForeignStudent::find($foreignerStudent->id);
        $student->student_service_id = null;
        $foreignerStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/foreign")->with('primary', 'Successfully Updated');
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
        $item = ForeignStudent::find($id);
        $item->delete();
        return redirect('/student/foreign')->with('primary', 'Successfully Deleted');
    }
}
