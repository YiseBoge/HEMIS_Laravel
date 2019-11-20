<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null management_level
 * @property Staff general
 * @method static ManagementStaff find($id)
 */
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

    /**
     * @return BelongsTo
     */
    public function general()
    {
        return $this->belongsTo('App\Models\Staff\Staff', 'staff_id');
    }

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return BelongsTo
     */
    public function jobTitle()
    {
        return $this->belongsTo('App\Models\Staff\JobTitle');
    }
}
