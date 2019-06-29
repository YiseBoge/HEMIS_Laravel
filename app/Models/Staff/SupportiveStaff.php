<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null staffRank
 * @property Staff general
 * @method static SupportiveStaff find($id)
 */
class SupportiveStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStaffRanks = [
        'a' => 'rank1',
        'b' => 'rank2',
        'c' => 'rank3',
    ];

    // Enums //
    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
