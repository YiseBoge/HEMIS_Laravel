<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int male_number
 * @property int female_number
 * @property string|null education_level
 * @property string|null study_place
 * @method static UpgradingStaff findOrFail(int $id)
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

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return UpgradingStaff::where(array(
                'department_id' => $this->department_id,
                'education_level' => $this->education_level,
                'study_place' => $this->study_place,
            ))->first() != null;
    }
}
