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
}