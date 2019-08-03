<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 */
class StaffLeave extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumLevelOfStudies = [
        'MASTERS' => 'Masters',
        'PHD' => 'Phd',
        'SPECIALITY' => 'Speciality',
        'SUB-SPECIALITY' => 'Sub-Speciality',
        'OTHERS' => 'Others'

    ];

    protected $enumPlaceOfStudies = [
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
}
