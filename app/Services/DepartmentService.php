<?php

namespace App\Services;

use App\Models\Department\Department;
use App\Models\Institution\AgeEnrollment;

/**
 * Class DepartmentService
 * @package App\Services
 */
class DepartmentService
{
    /**
     * @var Department|null
     */
    private $department = null;

    /**
     * DepartmentService constructor.
     * @param Department $department
     */
    function __construct(Department $department)
    {
        $this->department = $department;
    }

    // functions go here dependent on the department
    // can make functions to take in strings 'postgraduate', or 'undergraduate' then return accordingly

    /**
     * @param string $dedication
     * @return int
     */
    function academicExpatriateStaff($dedication)
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            $personalInfo = $academicStaff->general;
            if ($personalInfo->is_expatriate == true && $personalInfo->dedication == $dedication) {
                $total = $total + 1;
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
        foreach ($this->department->academicStaffs as $academicStaff) {
            foreach ($academicStaff->publications as $publication) {
                $total++;
            }
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @return int
     */
    function academicStaffData($sex, $otherRegion)
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $staff) {
            $personalInfo = $staff->general;
            if (($sex == 'Male' || $sex == 'Female') && $otherRegion) {
                if ($personalInfo->sex == $sex && $personalInfo->is_from_other_region == 1) $total++;
            } else if (!($sex == 'Male' || $sex == 'Female') && $otherRegion) {
                if ($personalInfo->is_from_other_region == 1) $total++;
            } else if ($sex == 'Male' || $sex == 'Female') {
                if ($personalInfo->sex == $sex) $total++;
            } else {
                $total++;
            }
            return $total;
        }
    }

    /**
     * @param $status
     * @param $sex
     * @return int
     */
    function academicStaffByStatus($sex, $status)
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            if ($status == "On Duty") {
                if ($sex == "All" && $academicStaff->staff_leave_id == 0) {
                    $total++;
                } else {
                    if ($academicStaff->general->sex == $sex && $academicStaff->staff_leave_id == 0) {
                        $total++;
                    }
                }
            } else if ($status == "On Leave") {
                if ($sex == "All" && $academicStaff->staff_leave_id != 0) {
                    $total++;
                } else {
                    if ($academicStaff->general->sex == $sex && $academicStaff->staff_leave_id != 0) {
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
    function fullEnrollment($sex)
    {
        $total = 0;
        foreach ($this->department->enrollmentsApproved as $enrollment) {
            if ($sex == "Female") {
                $total += $enrollment->female_students_number;
            } else if ($sex == "Male") {
                $total += $enrollment->male_students_number;
            } else {
                $total += $enrollment->male_students_number + $enrollment->female_students_number;
            }
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $age
     * @return int
     */
    function ageEnrollment($sex, $age)
    {
        $total = 0;
        foreach ($this->department->ageEnrollmentsApproved as $enrollment) {
            if (array_search($age, AgeEnrollment::getEnum('age')) && $enrollment->age == $age) {
                if ($sex == "Female") {
                    $total += $enrollment->female_students_number;
                } else if ($sex == "Male") {
                    $total += $enrollment->male_students_number;
                } else {
                    $total += $enrollment->male_students_number + $enrollment->female_students_number;
                }
            } else if (!array_search($age, AgeEnrollment::getEnum('age'))) {
                if ($sex == "Female") {
                    $total += $enrollment->female_students_number;
                } else if ($sex == "Male") {
                    $total += $enrollment->male_students_number;
                } else {
                    $total += $enrollment->male_students_number + $enrollment->female_students_number;
                }
            }
        }
        return $total;
    }

    /**
     * @return mixed
     */
    function specialNeedEnrollment()
    {
        return $this->department->specialNeedStudents->count();
    }

    /**
     * @return int
     */
    function disadvantagedStudentEnrollment()
    {
        $total = 0;
        foreach ($this->department->disadvantagedStudentEnrollmentsApproved as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    function emergingRegionsEnrollment()
    {
        $total = 0;
        foreach ($this->department->specialRegionEnrollmentsApproved as $enrollment) {
            if ($enrollment->region_type == "Emerging Regions") {
                $total += $enrollment->male_number + $enrollment->female_number;
            }
        }
        return $total;
    }

    /**
     * @return int
     */
    function ruralAreasEnrollment()
    {
        $total = 0;
        foreach ($this->department->ruralStudentEnrollmentsApproved->where('region', 'Rural')->all() as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $type
     * @return int
     */
    function dropout($sex, $type)
    {
        $total = 0;
        foreach ($this->department->studentAttritionsApproved->where('case', 'Dropouts')->where('student_type', $type)->all() as $attrition) {
            if ($sex == "Female") {
                $total += $attrition->female_students_number;
            } else if ($sex == "Male") {
                $total += $attrition->male_students_number;
            } else {
                $total += $attrition->male_students_number + $attrition->female_students_number;
            }
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $type
     * @return int
     */
    function academicDismissal($sex, $type)
    {
        $total = 0;
        foreach ($this->department->studentAttritionsApproved->whereIn('case', ['Academic Dismissals With Readmission', 'Academic Dismissals For Good'])->where('student_type', $type)->all() as $attrition) {
            if ($sex == "Female") {
                $total += $attrition->female_students_number;
            } else if ($sex == "Male") {
                $total += $attrition->male_students_number;
            } else {
                $total += $attrition->male_students_number + $attrition->female_students_number;
            }
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function foreignStudents()
    {
        return $this->department->foreignStudents()->count();
    }

    /**
     * @return int
     */
    public
    function patents()
    {
        $total = 0;
        foreach ($this->department->publicationsAndPatents as $pubAndPatent) {
            $total += $pubAndPatent->patents;
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
        foreach ($this->department->exitExaminationsApproved as $enrollment) {
            if ($passed) {
                if ($sex == 'Male') $total += $enrollment->males_passed;
                else if ($sex == 'Female') $total += $enrollment->females_passed;
                else $total += $enrollment->males_passed + $total += $enrollment->females_passed;
            } else {
                if ($sex == 'Male') $total += $enrollment->males_sat;
                else if ($sex == 'Female') $total += $enrollment->females_sat;
                else $total += $enrollment->males_sat + $total += $enrollment->females_sat;
            }
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function publicationByPostgraduates()
    {
        $total = 0;
        foreach ($this->department->publicationsAndPatents as $pubAndPatent) {
            $total += $pubAndPatent->student_publications;
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function jointEnrollment()
    {
        $total = 0;
        foreach ($this->department->jointProgramEnrollmentsApproved as $jointEnrollment) {
            $total += $jointEnrollment->male_students_number + $jointEnrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function diasporaCourses()
    {
        $total = 0;
        foreach ($this->department->diasporaCoursesApproved as $diasporaCourse) {
            // die('Course I');
            $total += $diasporaCourse->number_of_courses + $diasporaCourse->number_of_researches;
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function costSharing()
    {
        $total = 0;
        foreach ($this->department->costSharings as $costSharing) {
            // die('Course I');
            $total += $costSharing->pre_payment_amount;
        }
        return $total;
    }

    /**
     * @return int
     */
    function degreeEmployment()
    {
        $total = 0;
        foreach ($this->department->degreeEmploymentsApproved as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @param $sex
     * @param $student_type
     * @return int
     */
    function graduationData($sex, $student_type)
    {
        $total = 0;
        switch ($student_type) {
            case 'Emerging':
                foreach ($this->department->specialRegionEnrollmentsApproved()->where('student_type', 'Graduates')->where('region_type', 'Emerging') as $enrollment) {
                    if ($sex == "Female") {
                        $total += $enrollment->female_students_number;
                    } else if ($sex == "Male") {
                        $total += $enrollment->male_students_number;
                    } else {
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
                }
                break;
            case 'Disadvantaged':
                foreach ($this->department->disadvantagedStudentEnrollmentsApproved()->where('student_type', 'Graduates') as $enrollment) {
                    if ($sex == "Female") {
                        $total += $enrollment->female_students_number;
                    } else if ($sex == "Male") {
                        $total += $enrollment->male_students_number;
                    } else {
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
                }
                break;
            case 'Disabled':
                foreach ($this->department->specialNeedStudents as $enrollment) {
                    $personalInfo = $enrollment->general;
                    if ($personalInfo->student_type == 'Graduates') {
                        if ($sex == 'Male' || $sex == 'Female') {
                            if ($personalInfo->sex == "Female" && $sex == 'Female') {
                                $total++;
                            } else if ($personalInfo->sex == "Male" && $sex == 'Male') {
                                $total++;
                            }
                        } else {
                            $total++;
                        }
                    }
                }
                break;
            default:
                foreach ($this->department->enrollmentsApproved->where('student_type', 'Graduates') as $enrollment) {
                    if ($sex == "Female") {
                        $total += $enrollment->female_students_number;
                    } else if ($sex == "Male") {
                        $total += $enrollment->male_students_number;
                    } else {
                        $total += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
                }
        }

        return $total;
    }

    /**
     * @return int
     */
    function academicAttrition()
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $staff) {
            if ($staff->general->staffAttrition != null) {
                $total += 1;
            }
        }

        return $total;
    }

    /**
     * @return int
     */
    function otherRegionStudents()
    {
        $total = 0;
        foreach ($this->department->otherRegionStudentsApproved as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    public
    function allAcademicStaff()
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            $total += 1;
        }
        return $total;
    }

    public function researchBudget()
    {
        $total = 0;
        foreach ($this->department->researches as $research) {
            $total += ($research->budget_allocated + $research->budget_from_externals);
        }
        return $total;
    }

}