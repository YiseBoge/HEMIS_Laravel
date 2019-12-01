<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @method static SpecialRegionEnrollment findOrFail(int $id)
 * @property Uuid id
 * @property string|null region_type
 * @property string|null student_type
 * @property integer male_number
 * @property integer female_number
 */
class SpecialRegionEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumRegionTypes = [
        'EMERGING_REGIONS' => 'Emerging Regions',
        'PASTORAL_REGIONS' => 'Pastoral Regions'
    ];

    protected $enumStudentTypes = [
        'NORMAL' => 'Normal',
        'PROSPECTIVE' => 'Prospective Graduates',
        'GRADUATES' => 'Graduates'

    ];

    /**
     * @return BelongsTo
     */
    public function regionName()
    {
        return $this->belongsTo('App\Models\Institution\RegionName');
    }

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
        return SpecialRegionEnrollment::where(array(
                'department_id' => $this->department_id,
                'region_name_id' => $this->region_name_id,
                'student_type' => $this->student_type,
                'region_type' => $this->region_type,
            ))->first() != null;
    }
}
