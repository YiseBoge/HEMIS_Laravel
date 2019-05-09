<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Band\BandName;
use App\Models\Department\DepartmentName;
use App\Models\Band\Band;
use App\Models\Department\Department;
use App\Models\Student\Student;
use App\Models\Student\DisabledStudent;
use App\Models\Student\StudentService;
use App\Models\Student\DormitoryService;

class DisabledStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array(
            'students' => DisabledStudent::info()->get(),
            'page_name' => 'disabled.list'
        );
        return view("students.disabled.list")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => Band::getEnum("EducationPrograms"),
            'education_levels' => Band::getEnum("EducationLevels"),
            'food_service_types' => StudentService::getEnum("FoodServiceTypes"),
            'dormitory_service_types' => DormitoryService::getEnum("DormitoryServiceTypes"),
            'disabilitys' => DisabledStudent::getEnum("Disabilitys"),
            'page_name' => 'disabled.create'
        );
        return view("students.disabled.create")->with($data);
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
            'student_id' => 'required'
        ]);

        $dormitoryService = new DormitoryService;
        $dormitoryService->dormitory_service_type = $request->input("dormitory_service_type");
        $dormitoryService->block = $request->input("block_number");
        $dormitoryService->room_no = $request->input("room_number");

        $studentService = new StudentService;
        $studentService->food_service_type = $request->input("food_service_type");

        $dormitoryService->save();

        $dormitoryService->studentService()->save($studentService);

        $student = new Student;
        $student->name = $request->input("name");
        $student->student_id = $request->input("student_id");
        $student->phone_number = $request->input("phone_number");
        $student->birth_date = $request->input("birth_date");
        $student->sex = $request->input("sex");
        $student->remarks = $request->input("additional_remarks");

        $disabledStudent = new DisabledStudent;
        $disabledStudent->disability = $request->input("disability_type");

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'education_level' => $request->input("education_level"), 
            'education_program' => $request->input("program")])->first();
        if($band == null){
            $band = new Band;
            $band->education_level = $request->input("education_level");
            $band->education_program = $request->input("program");
            $band->institution_id = 0;
            $bandName->band()->save($band);
        }      

        $departmentName = DepartmentName::where('department_name', $request->input("department"))->first();
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'band_id' => $band->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->male_students_number = 0;
            $department->female_students_number = 0;
            $department->graduated_students_number = 0;
            $department->prospective_graduates_number = 0;
            $department->department_name_id = 0;            
            $band->departments()->save($department); 
            $departmentName->department()->save($department);                      
        }
        
        $department->disabledStudents()->save($disabledStudent);

        $disabledStudent = DisabledStudent::find($disabledStudent->id);

        $student->student_service_id = 0;

        $disabledStudent->general()->save($student);

        $studentService->student()->save($student);
        

        return redirect("/student/disabled");

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
            'student' => DisabledStudent::info()->find($id),
            'page_name' => 'disabled.details'
        );
        return view("students.disabled.details")->with($data);
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
            'student' => DisabledStudent::info()->find($id),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'disabled.edit'
        );
        return view("students.disabled.edit")->with($data);
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
            'student_id' => 'required'
        ]);

        $disabledStudent = DisabledStudent::find($id);
        
        $dormitoryService = $disabledStudent->general->studentService->dormitoryService;
        $dormitoryService->dormitory_service_type = $request->input("dormitory_service_type");
        $dormitoryService->block = $request->input("block_number");
        $dormitoryService->room_no = $request->input("room_number");

        $studentService = $disabledStudent->general->studentService;
        $studentService->food_service_type = $request->input("food_service_type");

        $dormitoryService->save();

        $dormitoryService->studentService()->save($studentService);

        $student = $disabledStudent->general;
        $student->name = $request->input("name");
        $student->student_id = $request->input("student_id");
        $student->phone_number = $request->input("phone_number");
        $student->birth_date = $request->input("birth_date");
        $student->sex = $request->input("sex");
        $student->remarks = $request->input("additional_remarks");

        $disabledStudent->disability = $request->input("disability_type");

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'education_level' => $request->input("education_level"), 
            'education_program' => $request->input("program")])->first();
        if($band == null){
            $band = new Band;
            $band->education_level = $request->input("education_level");
            $band->education_program = $request->input("program");
            $band->institution_id = 0;
            $bandName->band()->save($band);
        }      

        $departmentName = DepartmentName::where('department_name', $request->input("department"))->first();
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'band_id' => $band->id])->first();
        if($department == null){
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->male_students_number = 0;
            $department->female_students_number = 0;
            $department->graduated_students_number = 0;
            $department->prospective_graduates_number = 0;
            $department->department_name_id = 0;            
            $band->departments()->save($department); 
            $departmentName->department()->save($department);                      
        }
        
        $department->disabledStudents()->save($disabledStudent);

        $disabledStudent = DisabledStudent::find($disabledStudent->id);

        $student->student_service_id = 0;

        $disabledStudent->general()->save($student);

        $studentService->student()->save($student);
        

        return redirect("/student/disabled");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $disabledStudent = DisabledStudent::find($id);
        $student = $disabledStudent->general;
        $dormitoryService = $disabledStudent->general->studentService->dormitoryService;
        $studentService = $disabledStudent->general->studentService;
        $disabledStudent->delete();
        $student->delete();
        $dormitoryService->delete();
        $studentService->delete();
        return redirect('/student/disabled');
    }
}
