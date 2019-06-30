<?php

namespace App\Services;

use App\Models\Department\Department;

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
     * @return int
     */
    function academicExpatriateStaff()
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            if ($academicStaff->general->is_expatriate == true) {
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
    function academicStaffRate($sex, $otherRegion)
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            if ($otherRegion) {
                if ($sex == 'Female') {
                    if ($academicStaff->general->sex == 'Female' && $academicStaff->general->is_from_other_region == 1) {
                        $total++;
                    }
                } else {
                    if ($academicStaff->general->is_from_other_region == 1) {
                        $total++;
                    }
                }
            } else {
                if ($sex == 'Female') {
                    if ($academicStaff->general->sex == 'Female') {
                        $total++;
                    }
                } else {
                    $total++;
                }
            }
        }
        return $total;
    }

    /**
     * @param $sex
     * @return int
     */
    function enrollment($sex)
    {
        $total = 0;
        foreach ($this->department->enrollments as $enrollment) {
            if ($sex == "Female") {
                $total += $enrollment->female_students_number;
            } else {
                $total += $enrollment->male_students_number + $enrollment->female_students_number;
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
        foreach ($this->department->disadvantagedStudentEnrollments as $enrollment) {
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
        foreach ($this->department->emergingRegions as $enrollment) {
            $total += $enrollment->male_number + $enrollment->female_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    function ruralAreasEnrollment()
    {
        $total = 0;
        foreach ($this->department->ruralStudentEnrollments->where('region', 'Rural')->all() as $enrollment) {
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
        foreach ($this->department->studentAttritions->where('case', 'Dropouts')->where('student_type', $type)->all() as $attrition) {
            if ($sex == "Female") {
                $total += $attrition->female_students_number;
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
        foreach ($this->department->studentAttritions->whereIn('case', ['Academic Dismissals With Readmission', 'Academic Dismissals For Good'])->where('student_type', $type)->all() as $attrition) {
            if ($sex == "Female") {
                $total += $attrition->female_students_number;
            } else {
                $total += $attrition->male_students_number + $attrition->female_students_number;
            }
        }
        return $total;
    }

    /**
     * @return int
     */
    public function foreignStudents()
    {
        return $this->department->foreignStudents()->count();
    }

    /**
     * @return int
     */
    public function patents()
    {
        $total = 0;
        foreach ($this->department->publicationsAndPatents as $pubAndPatent) {
            $total += $pubAndPatent->patents;
        }
        return $total;
    }

    /**
     * @return int
     */
    function exitExamination()
    {
        $total = 0;
        foreach ($this->department->exitExaminations as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function publicationByPostgraduates()
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
    public function jointEnrollment()
    {
        $total = 0;
        foreach ($this->department->jointProgramEnrollments as $jointEnrollment) {
            $total += $jointEnrollment->male_students_number + $jointEnrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function diasporaCourses()
    {
        $total = 0;
        foreach ($this->department->diasporaCourses as $diasporaCourse) {
            // die('Course I');
            $total += $diasporaCourse->number_of_courses + $diasporaCourse->number_of_researches;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function costSharing()
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
        foreach ($this->department->degreeEmployments as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @param $sex
     * @return int
     */
    function graduationRate($sex)
    {
        $total = 0;
        foreach ($this->department->enrollments->where('student_type', 'Graduates') as $enrollment) {
            if ($sex == "Female") {
                $total += $enrollment->female_students_number;
            } else {
                $total += $enrollment->male_students_number + $enrollment->female_students_number;
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
        foreach ($this->department->otherRegionStudents() as $enrollment) {
            $total += $enrollment->male_students_number + $enrollment->female_students_number;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function allAcademicStaff()
    {
        $total = 0;
        foreach ($this->department->academicStaffs as $academicStaff) {
            $total += 1;
        }
        return $total;
    }

}