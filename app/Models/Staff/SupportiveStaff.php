<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

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
}
