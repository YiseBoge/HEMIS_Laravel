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


    function allDepartments(){
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
                   return $college->departments;
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


    function diasporaCourses($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->allDepartments();
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->diasporaCourses();       
        }
        return $total;
    }

    function foreignStudents($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->foreignStudents();       
        }
        return $total;
    }

    function patents($sex, $type, $educationLevel){
        $total = 0;
        $departments =  $this->allDepartments();
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->patents();       
        }
        return $total;
    }

    function publicationByPostgrads($sex, $type, $educationLevel){
        $total = 0;
        $departments =  $this->allDepartments();
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->publicationByPostgrads();       
        }
        return $total;
    }

    function jointEnrollment($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->jointEnrollment();       
        }
        return $total;
    }

    function costSharings($sex, $type, $educationLevel){
        $total = 0;
        $departments = $this->allDepartments($educationLevel);
        foreach($departments as $department){
           $departmentService = new DepartmentService($department);
           $total += $departmentService->costSharings();       
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

    function budgetNotFromGovernemnt(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach($band->colleges as $college){
                foreach($college->internalRevenues as $budget){
                    $total += $budget->income;
                }
            }
        }
    }
}