<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Institution\Institution;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ApprovalService
 * @package App\Services
 */
class ApprovalService
{
    public static function approveData(Collection $data)
    {
        $count = 0;
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["COLLEGE_APPROVED"];
                $item->save();
                $count++;
            }
        }
        return $count;
    }

    public static function approveDataByInstitution(Collection $data)
    {
        $count = 0;
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["COLLEGE_APPROVED"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                $item->save();
                $count++;
            }
        }
        return $count;
    }

    public static function approveAllInDepartment(Department $department, String $approveBy)
    {
        $count = 0;
        $dataList = array(
            $department->enrollments, $department->specialRegionEnrollments, $department->ruralStudentEnrollments,
            $department->disadvantagedStudentEnrollments, $department->specializingStudentEnrollments,
            $department->ageEnrollments, $department->jointProgramEnrollments, $department->exitExaminations,
            $department->degreeEmployments, $department->otherRegionStudents, $department->qualifiedInternships,
            $department->specialProgramTeachers, $department->upgradingStaffs, $department->postgraduateDiplomaTrainings,
            $department->teachers, $department->studentAttritions, $department->otherAttritions,
            $department->researches, $department->diasporaCourses,
        );

        foreach($dataList as $data){
            if($approveBy == "college"){
                $count += self::approveData($data);
            }
            else if($approveBy == "institution"){
                $count += self::approveDataByInstitution($data);
            }
        }
        return $count;
    }

    public static function approveAllDepartmentDataInCollege(College $college, $approveBy)
    {
        $count = 0;
        foreach($college->departments as $department){
            $count += self::approveAllInDepartment($department, $approveBy);
        }
        return $count;
    }

    public static function approveAllCollegeData(College $college, $approveBy)
    {
        $count = 0;
        $dataList = array(
            $college->budgets, $college->internalRevenues, $college->investments,
            $college->universityIndustryLinkages
        );

        foreach($dataList as $data){
            if($approveBy == "college"){
                $count += self::approveData($data);
            }
            else if($approveBy == "institution"){
                $count += self::approveDataByInstitution($data);
            }
        }
        return $count;
    }

    public static function approveAllInInstitution(Institution $institution)
    {
        $count = 0;
        foreach ($institution->colleges as $college) {
            $count += self::approveAllDepartmentDataInCollege($college, "institution");
            $count += self::approveAllCollegeData($college, "institution");
        }
        return $count;
    }
}