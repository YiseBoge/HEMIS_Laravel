<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ManagementStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumManagementLevels = [
        'SENIOR' => 'Senior',
        'MIDDLE' => 'Middle',
        'LOWER' => 'Lower'
    ];


    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
