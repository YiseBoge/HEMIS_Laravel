<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Institution;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ApprovalService
 * @package App\Services
 */
class HierarchyService
{
    public static function getDepartment(Institution $institution, CollegeName $collegeName, DepartmentName $departmentName, $educationLevel, $educationProgram, $yearLevel)
    {
        $college = self::fetchCollege($institution, $educationLevel, $educationProgram, $collegeName);
        $department = self::fetchDepartment($college, $yearLevel, $departmentName);

        return $department;
    }


    /**
     * @param Institution $institution
     * @param $educationLevel
     * @param $educationProgram
     * @param CollegeName $collegeName
     * @return College|Collection
     */
    private static function fetchCollege(Institution $institution, $educationLevel, $educationProgram, CollegeName $collegeName)
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
    private static function fetchDepartment(College $college, $yearLevel, DepartmentName $departmentName)
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
}