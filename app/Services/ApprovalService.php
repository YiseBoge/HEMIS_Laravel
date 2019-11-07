<?php

namespace App\Services;

use App\Models\Department\Department;
use App\Models\Institution\AgeEnrollment;

/**
 * Class DepartmentService
 * @package App\Services
 */
class ApprovalService
{
    function approveData($data){
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["COLLEGE_APPROVED"];
                $item->save();
            }
        }
    }
    
    function approveDataByInstitution($data){
        foreach ($data as $item) {
            if ($item->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                $item->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                $item->save();
            }
        }
    }
    
    function approveAllInDepartment($department){
        
        $dataList = array(
            $department->enrollment, $department->ruralStudentEnrollments, $department->disadvantagedStudentEnrollments,
            $department->specialRegionEnrollments, $department->ageEnrollments, $department->jointProgramEnrollments,
            $department->exitExaminations, $department->degreeEmployments, $department->otherRegionStudents, 
            $department->qualifiedInternships, $department->specialProgramTeachers, $department->upgradingStaffs, 
            $department->postgraduateDiplomaTrainings, $department->teachers, $department->studentAttritions, 
            $department->otherAttritions, $department->researches, $department->diasporaCourses
        );

        foreach($dataList as $data){
            approveData($data);
        }        
    } 

    function approveAllInCollege($college){
        foreach($college->departments as $department){
            approveAllInDepartment($department);
        }
    }

    function approveAllInInstitution($institution){
        foreach($institution->$band as $band){
            foreach($band->colleges as $colleges){
                approveAllInColleges($college);
            }            
        }
    }
}