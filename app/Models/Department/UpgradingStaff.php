<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class UpgradingStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationPrograms = [
        'MASTERS' => 'Masters',
        'PHD' => 'PhD',
        'SPECIALITY' => 'Speciality',
        'SUB_SPECIALITY' => 'Sub Speciality'
    ];

    protected $enumStudyPlaces = [
        'ETHIOPIA' => 'Ethiopia',
        'ABROAD' => 'Abroad'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
