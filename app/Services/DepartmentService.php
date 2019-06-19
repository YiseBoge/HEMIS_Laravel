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

    function expatriateStaff(){
        $total = 0;
        foreach ($this->department->expatriates as $expatriate){
            $total += $expatriate->male_number + $expatriate->female_number;
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
    }
}