<?php

namespace App\Services;

use App\Models\Institution\Institution;

/**
 * Class InstitutionService
 * @package App\Services
 */
class InstitutionService
{
    /**
     * @var Institution|null
     */
    private $institution = null;

    /**
     * InstitutionService constructor.
     * @param Institution $institution
     */
    function __construct(Institution $institution)
    {
        $this->institution = $institution;
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @param $educationLevel
     * @return array
     */
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

    /**
     * @param $educationLevel
     * @return int|mixed
     */
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

    /**
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @param $sex
     * @param $type
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return array
     */
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

    /**
     * @return int
     */
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

    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return array
     */
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

    /**
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int|mixed
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int
     */
    function totalBudget()
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
                foreach ($college->budgets as $budget) {
                    $total += $budget->allocated_budget + $budget->additional_budget;
                }
            }
        }

        return $total;
    }

    /**
     * @param $type
     * @return int
     */
    function budgetByType($type)
    {
        $total = 0;
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->budgets()->where('budget_type', $type)->get() as $budget) {
                    $total += $budget->allocated_budget + $budget->additional_budget;
                }
            }
        }

        return $total;
    }

    /**
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int
     */
    function nonUtilizedFunds()
    {
        $total = 0;
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->budgets as $budget) {
                    $total += $budget->allocated_budget + $budget->additional_budget - $budget->utilized_budget;
                }
            }
        }

        return $total;
    }

    /**
     * @return int
     */
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

    /**
     * @return int
     */
    function academicAttrition()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicAttrition();
        }
        return $total;
    }

    /**
     * @return int
     */
    function nonAcademicAttrition()
    {
        $total = 0;
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->technicalStaffs as $staff) {
                    if ($staff->general->staffAttrition != null) {
                        $total += 1;
                    }
                }
                foreach ($college->managementStaffs as $staff) {
                    if ($staff->general->staffAttrition != null) {
                        $total += 1;
                    }
                }
                foreach ($college->administrativeStaffs as $staff) {
                    if ($staff->general->staffAttrition != null) {
                        $total += 1;
                    }
                }
                foreach ($college->ictStaffs as $staff) {
                    if ($staff->general->staffAttrition != null) {
                        $total += 1;
                    }
                }
                foreach ($college->supportiveStaffs as $staff) {
                    if ($staff->general->staffAttrition != null) {
                        $total += 1;
                    }
                }
            }
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $type
     * @param $educationLevel
     * @return int
     */
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

    /**
     * @param $sex
     * @param $otherRegion
     * @return int
     */
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

    /**
     * @param $sex
     * @param $otherRegion
     * @return int
     */
    function managementStaffRate($sex, $otherRegion)
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->managementStaffs as $managementStaff) {
                if ($otherRegion) {
                    if ($sex == 'Female') {
                        if ($managementStaff->general->sex == 'Female' && $managementStaff->general->is_from_other_region == 1) {
                            $total++;
                        }
                    } else {
                        if ($managementStaff->general->is_from_other_region == 1) {
                            $total++;
                        }
                    }
                } else {
                    if ($sex == 'Female') {
                        if ($managementStaff->general->sex == 'Female') {
                            $total++;
                        }
                    } else {
                        $total++;
                    }
                }
            }
        }
        return $total;
    }

    /**
     * @return array
     */
    function colleges()
    {
        $colleges = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                array_push($colleges, $college);
            }
        }
        return $colleges;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @return int
     */
    function enrollmentsRate($sex, $otherRegion)
    {
        $total = 0;

        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            if($otherRegion){
                $total += $departmentService->otherRegionStudents();
            }else{
                $total += $departmentService->enrollment($sex);
            }
        }
        return $total;

    }

    /**
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int
     */
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

    /**
     * @return int
     */
    function unjustifiableExpenses()
    {
        return $this->institution->generalInformation->resource->unjustifiable_expenses;
    }
}