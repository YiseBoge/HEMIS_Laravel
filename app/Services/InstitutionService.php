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
    private $stemBands = ['Band 1', 'Band 2', 'Band 3', 'Band 4'];

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
    function stemEnrollment($sex, $educationLevel)
    {
        $total = 0;
        $departments = $this->__stemDepartments($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->fullEnrollment($sex);
        }
        return $total;
    }

    /**
     * @param $educationLevel
     * @return array
     */
    function __stemDepartments($educationLevel)
    {
        $departments = array();
        foreach ($this->institution->bands as $band) {
            if (array_search($band->bandName->acronym, $this->stemBands)) {
                foreach ($band->colleges as $college) {
                    if ($college->education_level == $educationLevel) {
                        foreach ($college->departments as $department) {
                            array_push($departments, $department);
                        }
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
    function specialNeedEnrollmentRate($educationLevel)
    {
        $total = 0;

        $totalSpecialNeed = $this->specialNeedEnrollment($educationLevel);

        $totalEnrollments = $this->fullEnrollment('All', $educationLevel);
        if ($totalEnrollments == 0) return 0;

        return $totalSpecialNeed / $totalEnrollments;
    }

    /**
     * @param $educationLevel
     * @return int|mixed
     */
    function specialNeedEnrollment($educationLevel)
    {
        $total = 0;
        $departments = $this->__departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->specialNeedEnrollment();
        }
        return $total;
    }

    /**
     * @param $educationLevel
     * @return array
     */
    function __departmentsByEducationLevel($educationLevel)
    {
        $departments = array();
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                if ($educationLevel == 'All') {
                    foreach ($college->departments as $department) {
                        array_push($departments, $department);
                    }
                } else if ($college->education_level == $educationLevel) {
                    foreach ($college->departments as $department) {
                        array_push($departments, $department);
                    }
                }
            }
        }
        return $departments;
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
    function fullEnrollment($sex, $educationLevel)
    {
        $total = 0;
        $departments = $this->__departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->fullEnrollment($sex);
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @param $age
     * @return int
     */
    function ageEnrollment($sex, $educationLevel, $age)
    {
        $total = 0;
        $departments = $this->__departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->ageEnrollment($sex, $age);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->dropout($sex, $type);
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $passed
     * @return int
     */
    function exitExamination($sex, $passed)
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->exitExamination($sex, $passed);
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
     * @param $student_type
     * @return int
     */
    function graduationData($sex, $educationLevel, $student_type)
    {
        $total = 0;
        $departments = $this->__departmentsByEducationLevel($educationLevel);

        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->graduationData($sex, $student_type);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
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
     * @param $sex
     * @return int|mixed
     */
    function qualifiedAcademicStaff($sex)
    {
        $total = 0;
        $departments = $this->departments();

        $qualifiedLevels = [
            'MASTERS' => 'Masters',
            'PHD' => 'PhD',
        ];

        foreach ($departments as $department) {
            if ($sex == 'Male' || $sex == 'Female') {
                foreach ($department->academicStaffs->where('hdp_trained', 1) as $staff) {
                    if (($staff->general->sex == $sex) && array_search($staff->general->academic_level, $qualifiedLevels))
                        $total++;
                }
            } else {
                foreach ($department->academicStaffs->where('hdp_trained', 1) as $staff) {
                    if (array_search($staff->general->academic_level, $qualifiedLevels)) $total++;
                }
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
                        $total += $departmentService->fullEnrollment("All");
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
                foreach ($college->internalRevenuesApproved as $budget) {
                    $total += $budget->income;
                }
                foreach ($college->investmentsApproved as $budget) {
                    $total += $budget->cost_incurred;
                }
                foreach ($college->budgetsApproved as $budget) {
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
                foreach ($college->budgetsApproved()->where('budget_type', $type)->get() as $budget) {
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
        // die ($this->institution);
        foreach ($this->institution->bands as $band) {
            foreach ($band->colleges as $college) {
                foreach ($college->internalRevenuesApproved as $budget) {
                    $total += $budget->income;
                }
                foreach ($college->investmentsApproved as $budget) {
                    $total += $budget->cost_incurred;
                }
            }
        }

        return $total;
    }

    /**
     * @param $dedication
     * @return int
     */
    function expatriateStaff($dedication)
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicExpatriateStaff($dedication);
        }
        return $total;
    }

    /**
     * @return int
     */
    function improperlyUtilizedFunds()
    {
        return $this->institution->generalInformation->resource->unjustifiable_expenses;
    }

    /**
     * @return int
     */
    function researchBudget()
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->researchBudget();
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
        $departments = $this->__departmentsByEducationLevel($educationLevel);
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicDismissal($sex, $type);
        }
        return $total;
    }

    /**
     * @param $type
     * @param $sex
     * @param $otherRegion
     * @param $attrition
     * @return int
     */
    function staff($type, $sex, $otherRegion, $attrition)
    {
        $total = 0;
        $colleges = $this->colleges();
        $departments = $this->departments();
        switch ($type) {
            case 'Academic':
                foreach ($departments as $department) {
                    $departmentService = new DepartmentService($department);
                    $total += $departmentService->academicStaffData($sex, $otherRegion);
                }
                break;
            case 'Administrative':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->administrativeStaffs, $attrition);
                }
                break;
            case 'Technical':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->technicalStaffs, $attrition);
                }
                break;
            case 'Management':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->managmentStaffs, $attrition);
                }
                break;
            case 'Senior Management':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->managementStaffs()->where('management_level', 'Senior')->get(), $attrition);
                }
                break;
            case 'Middle Management':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->managementStaffs()->where('management_level', 'Middle')->get(), $attrition);
                }
                break;
            case 'Lower Management':
                foreach ($colleges as $college) {
                    $total += $this->countStaffs($sex, $otherRegion, $college->managementStaffs()->where('management_level', 'Lower')->get(), $attrition);
                }
                break;
            default:
                foreach ($departments as $department) {
                    $departmentService = new DepartmentService($department);
                    $total += $departmentService->academicStaffData($sex, $otherRegion);
                }
                foreach ($colleges as $college) {
                    $staffs = $college->administrativeStaff +
                        $college->technicalStaff +
                        $college->managmentStaff;
                    $total += $this->countStaffs($sex, $otherRegion, $staffs, $attrition);
                }
                break;
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
    function academicStaffData($sex, $otherRegion)
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffData($sex, $otherRegion);
        }
        return $total;

    }

    /**
     * @param $status
     * @param $sex
     * @return int
     */
    function academicStaffByStatus($sex, $status)
    {
        $total = 0;
        $departments = $this->departments();
        foreach ($departments as $department) {
            $departmentService = new DepartmentService($department);
            $total += $departmentService->academicStaffByStatus($sex, $status);
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
                    } else if ($sex == 'Male') {
                        if ($managementStaff->general->sex == 'Male' && $managementStaff->general->is_from_other_region == 1) {
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
                    } else if ($sex == 'Male') {
                        if ($managementStaff->general->sex == 'Male') {
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
     * @param $sex
     * @return int
     */
    function administrativeStaff($sex)
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->administrativeStaffs as $administrativeStaff) {
                if ($sex == "All") {
                    $total++;
                } else {
                    if ($administrativeStaff->general->sex == $sex) {
                        $total++;
                    }
                }
            }
        }

        return $total;
    }

    /**
     * @param $sex
     * @return int
     */
    function technicalStaff($sex)
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->technicalStaffs as $technicalStaff) {
                if ($sex == "All") {
                    $total++;
                } else {
                    if ($technicalStaff->general->sex == $sex) {
                        $total++;
                    }
                }
            }
        }

        return $total;
    }

    /**
     * @param $type
     * @return int
     */
    function budget($type)
    {
        $total = 0;
        $colleges = $this->colleges();
        foreach ($colleges as $college) {
            foreach ($college->budgets as $budget) {
                if ($budget->budget_type == $type) {
                    $total += $budget->allocated_budget + $budget->additional_budget;
                }
            }
        }

        return $total;
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
            if ($otherRegion) {
                $total += $departmentService->otherRegionStudents();
            } else {
                $total += $departmentService->fullEnrollment($sex);
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
            $total += $departmentService->fullEnrollment("All");
        }

        return $total;
    }

    /**
     * @param $smart
     * @return int
     */
    function classrooms($smart)
    {
        $res = $this->institution->generalInformation->resource;
        return $smart ? $res->number_of_smart_classrooms : $res->number_of_classrooms;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @param $staffs
     * @param $attrition
     * @return mixed
     */
    private function countStaffs($sex, $otherRegion, $staffs, $attrition)
    {
        $total = 0;
        foreach ($staffs as $staff) {
            $personalInfo = $staff->general;
            if (!$attrition || ($personalInfo->staffAttrition != null)) {
                if (($sex == 'Male' || $sex == 'Female') && $otherRegion) {
                    if ($personalInfo->sex == $sex && $personalInfo->is_from_other_region == 1) $total++;
                } else if (!($sex == 'Male' || $sex == 'Female') && $otherRegion) {
                    if ($personalInfo->is_from_other_region == 1) $total++;
                } else if ($sex == 'Male' || $sex == 'Female') {
                    if ($personalInfo->sex == $sex) $total++;
                } else {
                    $total++;
                }
            }
        }
        return $total;
    }
}