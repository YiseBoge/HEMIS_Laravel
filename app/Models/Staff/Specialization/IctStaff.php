<?php

namespace App\Models\Staff\Specialization;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class IctStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function general(){
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function ictType(){
        return $this->hasOne('App\Models\Staff\IctStaffType');
    }



    // Enums //
    protected $enumStaffRanks = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}