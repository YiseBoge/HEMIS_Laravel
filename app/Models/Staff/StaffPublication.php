<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StaffPublication extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function academicStaff()
    {
        return $this->belongsto('App\Models\Staff\AcademicStaff');
    }
}
