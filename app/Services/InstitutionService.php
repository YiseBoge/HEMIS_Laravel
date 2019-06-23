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

    function departmentsByEducationLevel($educationLevel)
    {
        $departments = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                if ($college->education_level == $educationLevel) {
                    foreach ($college->departments as $department) {
                        array_push($departments, $department);
                    }

                }
            }
        }
        return $departments;
    }


    function allDepartments()
    {
        $departments = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->departments as $department) {
                    array_push($departments, $department);
                }
            }
        }
        return $departments;
    }

    function departments()
    {
        $departments = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->departments as $department) {
                    array_push($departments, $department);
                }
            }
        }
        return $departments;
    }

    function colleges()
    {
        $colleges = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                $colleges[] = $college;
            }
        }
        return $colleges;
    }

    function enrollment($sex, $educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->enrollment($sex);
        }
        return $total;
    }

    function specialNeedEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->specialNeedEnrollment();
        }
        return $total;
    }

    function disadvantagedStudentEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->disadvantagedStudentEnrollment();
        }
        return $total;
    }

    function emergingRegionsEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->emergingRegionsEnrollment();
        }
        return $total;
    }

    function ruralAreasEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->ruralAreasEnrollment();
        }
        return $total;
    }

    function dropout($sex, $type, $educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->dropout($sex, $type);
        }
        return $total;
    }

    function exitExamination()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->exitExamination();
        }
        return $total;
    }

    function degreeEmployment()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->degreeEmployment();
        }
        return $total;
    }

    function graduationRate($sex, $educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->graduationRate($sex);
        }
        return $total;
    }

    function diasporaCourses()
    {
        $total = 0;
        $departments = $this->allDepartments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->diasporaCourses();
        }
        return $total;
    }

    function foreignStudents($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->foreignStudents();
        }
        return $total;
    }

    function patents()
    {
        $total = 0;
        $departments = $this->allDepartments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->patents();
        }
        return $total;
    }

    function publicationByPostgraduates()
    {
        $total = 0;
        $departments = $this->allDepartments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->publicationByPostgraduates();
        }
        return $total;
    }

    function jointEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->jointEnrollment();
        }
        return $total;
    }

    function costSharing()
    {
        $total = 0;
        $departments = $this->allDepartments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->costSharing();
        }
        return $total;
    }

    function qualifiedStaff()
    {
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

        foreach ($departments as $department) {
            foreach ($department->academicStaffs as $staff) {
                $total += $staffRankValues[$staff->staffRank];
            }
        }

        return $total;
    }

    function enrollmentInScienceAndTechnology()
    {
        $total = 0;
        foreach ($this->institution->bands as $band) {
            if ($band->bandName->band_name == "Engineering and Technology" || $band->bandName->band_name == "Natural and Computational Sciences") {
                foreach ($band->colleges as $college) {
                    foreach ($college->departments as $department) {
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

    function budgetNotFromGovernment()
    {
        $total = 0;
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->internalRevenues as $budget) {
                    $total += $budget->income;
                }
                foreach ($college->investments as $budget) {
                    $total += $budget->cost_incurred;
                }
            }
        }
        return $total;
    }

    function expatriateStaff()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicExpatriateStaff();
        }

        return $total;
    }

    function nonUtilizedFunds(){
        $total = 0;
        foreach($this->institution->bands as $band){
            foreach ($band->colleges as $college) {
                foreach($college->budgets as $budget){
                    $total += $budget->allocated_budget + $budget->additional_budget - $budget->utilized_budget;
                }
            }
        }

        return $total;
    }

    function academicStaffPublication()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffPublication();
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
                foreach ($college->technicalStaffs as $staff) {
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach ($college->managementStaffs as $staff) {
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach ($this->institution->adminAndNonAcademicStaff as $staff) {
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach ($college->ictStaffs as $staff) {
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
                foreach ($college->supportiveStaffs as $staff) {
                    if($staff->general->staffAttrition != null){
                        $total += 1;
                    }
                }
            }
        }
        return $total;
    }

    function academicDismissal($sex, $type, $educationLevel)
    {
        $total = 0;
        $departments = $this->departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicDismissal($sex, $type);
        }
        return $total;
    }

    function academicStaffRate($sex, $otherRegion)
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffRate($sex, $otherRegion);
        }
        return $total;

    }

    function managementStaffRate($sex, $otherRegion)
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->managementStaffs as $managementStaff) {
                if ($otherRegion == true) {
                    if ($managementStaff->general->sex == $sex && $managementStaff->general->is_from_other_region == 1) {
                        $total = $total + 1;
                    }
                } else {
                    if ($managementStaff->general->sex == $sex && $managementStaff->general->is_from_other_region == 0) {
                        $total = $total + 1;
                    }
                }

            }

        }

        return $total;
    }

    function enrollmentsRate($sex, $otherRegion)
    {
        $total = 0;

        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            if ($sex == "Female" && !$otherRegion) {
                $total += $departmentService->enrollment("Female");
            } elseif ($otherRegion) {
                $total += $departmentService->otherRegionStudents();
            }
        }
        return $total;

    }

    function allAcademicStaff()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->allAcademicStaff();
        }
        return $total;

    }

    function allManagementStaff()
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->managementStaffs as $managementStaff) {
                $total++;
            }
        }

        return $total;
    }

    function allEnrollment()
    {
        $total = 0;

        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->enrollment("All");
        }

        return $total;
    }
}