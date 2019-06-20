<?php

namespace App\Services;

use App\Models\Department\Department;

class DepartmentService
{
    private $department = null;

    function __construct(Department $department)
    {
        $this->department = $department;
    }

    // functions go here dependent on the department
    // can make functions to take in strings 'postgraduate', or 'undergraduate' then return accordingly

    function academicExpatriateStaff(){
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff){
            if($academicStaff->general->is_expatriate==true){
                $total= $total +1;
            }
        }
        return $total;

    }

    function academicStaffPublication(){
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff){
            foreach ($academicStaff->publications as $publication){
                $total= $total +1;
            }
        }
        return $total;
    }

    function academicStaffRate($sex,$otherRegion){
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff){
            if($otherRegion == true){
                if ($academicStaff->general->sex == $sex && $academicStaff->general->is_from_other_region == 1){
                    $total = $total + 1;
                }
            }
            else{
                if($academicStaff->general->sex == $sex && $academicStaff->general->is_from_other_region==0){
                    $total = $total +1;
                }
            }
        }
        return $total;
    }

    function enrollment($sex){
        $total = 0;
        foreach ($this->department->enrollments as $enrollment){
            if($sex == "Female"){
                $total += $enrollment->female_students_number;
            }else{
                $total += $enrollment->male_students_number + $enrollment->female_students_number;
            }            
        }
        return $total;
    }

    function specialNeedEnrollment(){
        return $this->department->specialNeedStudents->count();
    }

    function disadvantagedStudentEnrollment(){
        $total = 0;
        foreach ($this->department->disadvantagedStudentEnrollments as $enrollment){
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    function emergingRegionsEnrollment(){
        $total = 0;
        foreach ($this->department->emergingRegions as $enrollment){
            $total += $enrollment->male_number + $enrollment->female_number;
        }
        return $total;
    }

    //???
    function ruralAreasEnrollment(){
        $total = 0;
        foreach ($this->department->ruralStudentEnrollments->where('region', 'Rural')->all() as $enrollment){
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }

        return $total;
    }

    function dropout($sex, $type){
        $total = 0;
        foreach ($this->department->studentAttritions->where('case','Dropouts')->where('student_type', $type)->all() as $attrition){
            if($sex == "Female"){
                $total += $attrition->female_students_number;
            }else{
                $total += $attrition->male_students_number + $attrition->female_students_number;
            }            
        }
        return $total;
    }

    function academicDismissal($sex, $type){
        $total = 0;
        foreach ($this->department->studentAttritions->whereIn('case',['Academic Dismissals With Readmission', 'Academic Dismissals For Good'])->where('student_type', $type)->all() as $attrition){
            if($sex == "Female"){
                $total += $attrition->female_students_number;
            }else{
                $total += $attrition->male_students_number + $attrition->female_students_number;
            }            
        }
        return $total;
    }

    function exitExamination(){
        $total = 0;
        foreach ($this->department->exitExaminations as $enrollment){
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    function degreeEmployment(){
        $total = 0;
        foreach ($this->department->degreeEmployments as $enrollment){
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    function graduationRate($sex){
        $total = 0;
        foreach ($this->department->enrollments->where('student_type', 'Graduates') as $enrollment){
            if($sex == "Female"){
                $total += $enrollment->female_students_number;
            }else{
                $total += $enrollment->male_students_number + $enrollment->female_students_number;
            }
        }

        return $total;
    }
}