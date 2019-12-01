<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Institution;
use App\Models\Staff\Staff;
use App\Models\Student\DormitoryService;
use App\Models\Student\Student;
use App\Models\Student\StudentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class ApprovalService
 * @package App\Services
 */
class HierarchyService
{
    /**
     * @param Institution $institution
     * @param CollegeName $collegeName
     * @param DepartmentName $departmentName
     * @param $educationLevel
     * @param $educationProgram
     * @param $yearLevel
     * @return Department
     */
    public static function getDepartment(Institution $institution, CollegeName $collegeName,
                                         DepartmentName $departmentName, $educationLevel, $educationProgram, $yearLevel)
    {
        $college = self::fetchCollege($institution, $collegeName, $educationLevel, $educationProgram);
        $department = self::fetchDepartment($college, $departmentName, $yearLevel);
        return $department;
    }

    /**
     * @param Institution $institution
     * @param CollegeName $collegeName
     * @param $educationLevel
     * @param $educationProgram
     * @return College|Collection
     */
    public static function getCollege(Institution $institution, CollegeName $collegeName, $educationLevel, $educationProgram)
    {
        return self::fetchCollege($institution, $collegeName, $educationLevel, $educationProgram);;
    }


    /**
     * @param Institution $institution
     * @param $educationLevel
     * @param $educationProgram
     * @param CollegeName $collegeName
     * @return College|Collection
     */
    private static function fetchCollege(Institution $institution, CollegeName $collegeName, $educationLevel, $educationProgram)
    {
        $college = $institution->colleges()->where(['college_name_id' => $collegeName->id,
            'education_level' => $educationLevel, 'education_program' => $educationProgram])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $educationLevel;
            $college->education_program = $educationProgram;
            $college->college_name_id = $collegeName->id;
            $institution->colleges()->save($college);
        }
        return $college;
    }

    /**
     * @param College $college
     * @param $yearLevel
     * @param DepartmentName $departmentName
     * @return Department
     */
    private static function fetchDepartment(College $college, DepartmentName $departmentName, $yearLevel)
    {
        $department = $college->departments()->where(['department_name_id' => $departmentName->id,
            'year_level' => Department::getEnum('year_level')[$yearLevel]])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $yearLevel;
            $department->department_name_id = $departmentName->id;
            $college->departments()->save($department);
        }
        return $department;
    }

    /**
     * @param Request $request
     * @param Staff $staff
     */
    public static function populateStaff(Request $request, Staff $staff)
    {
        $staff->name = $request->input('name');
        $staff->birth_date = $request->input('birth_date');
        $staff->sex = $request->input('sex');
        $staff->phone_number = $request->input('phone_number');
        $staff->nationality = $request->input('nationality');
        $staff->salary = $request->input('salary');
        $staff->service_year = $request->input('service_year');
        $staff->employment_type = $request->input('employment_type');
        $staff->dedication = $request->input('dedication');
        $staff->academic_level = $request->input('academic_level');
        $staff->is_expatriate = $request->has('expatriate');
        $staff->is_from_other_region = $request->has('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? "" : $request->input('additional_remark');
    }

    /**
     * @param Request $request
     * @param DormitoryService $dormitoryService
     * @param StudentService $studentService
     * @param Student $student
     */
    public static function populateStudent(Request $request, DormitoryService $dormitoryService, StudentService $studentService, Student $student)
    {
        $dormitoryService->dormitory_service_type = $request->input("dormitory_service_type");
        $dormitoryService->block = $request->input("block_number");
        $dormitoryService->room_no = $request->input("room_number");
        $studentService->food_service_type = $request->input("food_service_type");
        $student->name = $request->input("name");
        $student->student_id = $request->input("student_id");
        $student->phone_number = $request->input("phone_number");
        $student->birth_date = $request->input("birth_date");
        $student->sex = $request->input("sex");
        $student->remarks = $request->input("additional_remarks");
    }
}