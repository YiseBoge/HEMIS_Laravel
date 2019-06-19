<?php

namespace App\Services;

use App\Models\Institution\Institution;
use App\Models\Staff\AcademicStaff;

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

    function departments(){
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
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

    function exitExamination(){
        $total = 0;
        $departments = $this->departments();
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->exitExamination();       
        }
        return $total;
    }

    function degreeEmployment(){
        $total = 0;
        $departments = $this->departments();
        foreach($departments as $department){
            $departmentService = new DepartmentService($department);
            $total += $departmentService->degreeEmployment();
        }
        return $total;
    }

    function graduationRate($sex, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->graduationRate($sex);       
        }
        return $total;
    }

    function qualifiedStaff(){
        $total = 0;
        $departments = $this->departments();

       $staffRankValues = [
            'Graduate Assistant I' => 1,
            'Graduate Assistant II' => 2,
            'Assistant Lecturer' => 3,
            'Lecturer' => 4,
            'Assistant Professor' => 5,
            'Associate Professor' => 6,
            'Professor' => 7,
            'Others' => 0
        ];

        foreach($departments as $department){
            foreach($department->academicStaffs as $staff){
                $total += $staffRankValues[$staff->staffRank];
            }
        }

        return $total;
    }

    function enrollmentInScienceAndTechnology(){
        $total = 0; 
       foreach($this->institution->bands as $band){
           if($band->bandName->band_name == "Engineering and Technology" || $band->bandName->band_name == "Natural and Computational Sciences"){
               foreach($band->colleges as $college){
                   foreach($college->departments as $department){
                        $departmentService = new DepartmentService($department);
                        $total += $departmentService->enrollment("All");
                   }
               }
           }
       }
       return $total;
    }

    function totalBudget(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
                foreach($college->internalRevenues as $budget){
                    $total += $budget->income;
                }
                foreach($college->investments as $budget){
                    $total += $budget->cost_incurred;
                }
                foreach($college->budgets as $budget){
                    $total += $budget->allocated_budget + $budget->additional_budget;
                }
            }
        }

        return $total;
    }

    function budgetNotFromGovernemnt(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
                foreach($college->internalRevenues as $budget){
                    $total += $budget->income;
                }
                foreach($college->investments as $budget){
                    $total += $budget->cost_incurred;
                }
            }
        }

        return $total;
    }

    function nonUtilizedFunds(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){                
                foreach($college->budgets as $budget){
                    $total += $budget->allocated_budget + $budget->additional_budget - $budget->utilized_budget;
                }
            }
        }

        return $total;
    }

    function academicAttrition(){
        $total = 0;
        $departments = $this->departments();
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->academicAttrition();       
        }
        return $total;
    }

    function nonAcademicAttrition(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){                
                foreach($college->technicalStaffs as $budget){
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach($college->managementStaffs as $budget){
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach($college->administrativeStaffs as $budget){
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach($college->ictStaffs as $budget){
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach($college->supportiveStaffs as $budget){
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
            }
        }
        return $total;
    }

}