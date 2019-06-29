<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null male_number
 * @property array|string|null female_number
 * @property array|string|null education_level
 * @property array|string|null study_place
 */
class UpgradingStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationLevels = [
        'MASTERS' => 'Masters',
        'PHD' => 'PhD',
        'SPECIALITY' => 'Speciality',
        'SUB SPECIALITY' => 'Sub Speciality'
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
