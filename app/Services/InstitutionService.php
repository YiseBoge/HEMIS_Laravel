<?php

namespace App\Services;

use App\Models\Institution\Institution;

class InstitutionService
{
    private $institution = null;

    function __construct(Institution $institution)
    {
        $this->institution = $institution;
    }

    // call all needed department service methods similar to what happened at the GeneralReportService

    function departmentsByEducationLevel($educationLevel){
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
                if($college->education_level == $educationLevel){
                   return $college->departments;
                }
            }
        }
    }

    function department(){
        foreach ($this->institution->bands as $band){
            foreach ($band->colleges as $college){
                return $college->departments;
            }
        }
    }
    function enrollment($sex, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->enrollment($sex);       
        }
        return $total;
    }

    function specialNeedEnrollment($educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->specialNeedEnrollment();
        }
        return $total;
    }

    function disadvantagedStudentEnrollment($educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->disadvantagedStudentEnrollment();
        }
        return $total;
    }

    function emergingRegionsEnrollment($educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->emergingRegionsEnrollment();
        }
        return $total;
    }

    function ruralAreasEnrollment($educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->ruralAreasEnrollment();
        }
        return $total;
    }

    function dropout($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->dropout($sex, $type);       
        }
        return $total;
    }

    function academicDismissal($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->academicDismissal($sex, $type);       
        }
        return $total;
    }

    function expatriateStaff(){
        $total = 0;
        $departments = $this ->department();
        foreach ($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicExpatriateStaff();
        }
        return $total;
    }

    function academicStaffPublication(){
        $total = 0;
        $departments = $this ->department();
        foreach ($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffPublication();
        }
        return $total;
    }

    function academicStaffRate($sex,$otherRegion){
        $total = 0;
        $departments = $this ->department();
        foreach ($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffRate($sex,$otherRegion);
        }
        return $total;
    }

}