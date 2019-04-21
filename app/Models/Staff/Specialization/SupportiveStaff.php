<?php

namespace App\Models\Staff\Specialization;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class SupportiveStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function general(){
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }



    // Enums //
    protected $enumStaffRanks = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}
