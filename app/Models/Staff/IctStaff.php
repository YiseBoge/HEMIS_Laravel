<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null staffRank
 * @property array|string|null ict_staff_type_id
 * @property int institution_id
 * @property Staff general
 * @method static IctStaff find($id)
 */
class IctStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStaffRanks = [
        'a' => 'rank1',
        'b' => 'rank2',
        'c' => 'rank3',
    ];

    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function ictType()
    {
        return $this->belongsTo('App\Models\Staff\IctStaffType', 'ict_staff_type_id');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
