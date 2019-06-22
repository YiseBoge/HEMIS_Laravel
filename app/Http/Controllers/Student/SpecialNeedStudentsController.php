<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Student\DormitoryService;
use App\Models\Student\SpecialNeedStudent;
use App\Models\Student\Student;
use App\Models\Student\StudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialNeedStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'students' => SpecialNeedStudent::info()->get(),
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'food_service_types' => StudentService::getEnum("FoodServiceTypes"),
            'dormitory_service_types' => DormitoryService::getEnum("DormitoryServiceTypes"),
            'disabilitys' => SpecialNeedStudent::getEnum("Disabilitys"),
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
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'student_id' => 'required'
        ]);
        $dormitoryService = new DormitoryService;
        $dormitoryService->dormitory_service_type = $request->input("dormitory_service_type");
        $dormitoryService->block = $request->input("block_number");
        $dormitoryService->room_no = $request->input("room_number");
        $studentService = new StudentService;
        $studentService->food_service_type = $request->input("food_service_type");
        $student = new Student;
        $student->name = $request->input("name");
        $student->student_id = $request->input("student_id");
        $student->phone_number = $request->input("phone_number");
        $student->birth_date = $request->input("birth_date");
        $student->sex = $request->input("sex");
        $student->remarks = $request->input("additional_remarks");
        $specialNeedStudent = new SpecialNeedStudent;
        $specialNeedStudent->disability = $request->input("disability_type");

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
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $request->input("education_level");
            $college->education_program = $request->input("program");
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->specialNeedStudents()->save($specialNeedStudent);
        $specialNeedStudent = SpecialNeedStudent::find($specialNeedStudent->id);
        $student->student_service_id = 0;
        $specialNeedStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/special-need");
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'student' => SpecialNeedStudent::info()->find($id),
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $data = array(
            'student' => SpecialNeedStudent::info()->find($id),
            'bands' => BandName::all(),
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
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'student_id' => 'required'
        ]);
        $specialNeedStudent = SpecialNeedStudent::find($id);

        $dormitoryService = $specialNeedStudent->general->studentService->dormitoryService;
        $dormitoryService->dormitory_service_type = $request->input("dormitory_service_type");
        $dormitoryService->block = $request->input("block_number");
        $dormitoryService->room_no = $request->input("room_number");
        $studentService = $specialNeedStudent->general->studentService;
        $studentService->food_service_type = $request->input("food_service_type");
        $student = $specialNeedStudent->general;
        $student->name = $request->input("name");
        $student->student_id = $request->input("student_id");
        $student->phone_number = $request->input("phone_number");
        $student->birth_date = $request->input("birth_date");
        $student->sex = $request->input("sex");
        $student->remarks = $request->input("additional_remarks");
        $specialNeedStudent->disability = $request->input("disability_type");

        $user = Auth::user();
        if ($user == null) return redirect('/login');
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
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $request->input("education_level");
            $college->education_program = $request->input("program");
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $dormitoryService->save();
        $dormitoryService->studentService()->save($studentService);
        $department->specialNeedStudents()->save($specialNeedStudent);
        $specialNeedStudent = SpecialNeedStudent::find($specialNeedStudent->id);
        $student->student_service_id = 0;
        $specialNeedStudent->general()->save($student);
        $studentService->student()->save($student);

        return redirect("/student/special-need");
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $specialNeedStudent = SpecialNeedStudent::find($id);
        $student = $specialNeedStudent->general;
        $dormitoryService = $specialNeedStudent->general->studentService->dormitoryService;
        $studentService = $specialNeedStudent->general->studentService;
        $specialNeedStudent->delete();
        $student->delete();
        $dormitoryService->delete();
        $studentService->delete();
        return redirect('/student/special-need');
    }
}
