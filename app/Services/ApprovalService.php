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
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["COLLEGE_APPROVED"];
                $item->save();
            }
        }
    }

    public static function approveDataByInstitution(Collection $data)
    {
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["COLLEGE_APPROVED"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                $item->save();
            }
        }
    }

    public static function approveAllInDepartment(Department $department, String $approveBy)
    {

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
                self::approveData($data);
            }
            else if($approveBy == "institution"){
                self::approveDataByInstitution($data);
            }
        }
    }

    public static function approveAllDepartmentDataInCollege(College $college, $approveBy)
    {
        foreach($college->departments as $department){
            self::approveAllInDepartment($department, $approveBy);
        }
    }

    public static function approveAllCollegeData(College $college, $approveBy)
    {
        $dataList = array(
            $college->budgets, $college->internalRevenues, $college->investments,
            $college->universityIndustryLinkages
        );

        foreach($dataList as $data){
            if($approveBy == "college"){
                self::approveData($data);
            }
            else if($approveBy == "institution"){
                self::approveDataByInstitution($data);
            }
        }
    }

    public static function approveAllInInstitution(Institution $institution)
    {
        foreach ($institution->colleges as $college) {
            self::approveAllDepartmentDataInCollege($college, "institution");
            self::approveAllCollegeData($college, "institution");
        }
    }
}