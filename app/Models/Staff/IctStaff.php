<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null staffRank
 * @property Uuid ict_staff_type_id
 * @property Uuid institution_id
 * @property Staff general
 * @method static IctStaff find($id)
 */
class IctStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

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
    public function ictType()
    {
        return $this->belongsTo('App\Models\Staff\IctStaffType', 'ict_staff_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
