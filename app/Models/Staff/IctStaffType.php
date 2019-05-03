<?php

namespace App\Models\Staff;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class IctStaffType extends Model
{
    use Uuids;

    public $incrementing = false;
}
