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
 * @property Uuid institution_id
 * @property Staff general
 * @method static TechnicalStaff find($id)
 */
class TechnicalStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStaffRanks = [
        'TECHNICAL_ASSISTANT_I' => 'Technical Assistant I',
        'TECHNICAL_ASSISTANT_II' => 'Technical Assistant II',
        'TECHNICAL_ASSISTANT_III' => 'Technical Assistant III',
        'OTHERS' => 'Others',
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
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @return BelongsTo
     */
    public function jobTitle()
    {
        return $this->belongsTo('App\Models\Staff\JobTitle');
    }
}
