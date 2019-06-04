<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasOne('App\Models\Staff\IctStaffType');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
