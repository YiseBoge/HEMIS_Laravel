<?php

namespace App;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InistitutionBSCInfo extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumTypes = [
        'BASELINE' => 'Baseline',
        'CUURENT' => 'Current',
        'TARGET' => 'Target',
    ];

    public function InstitutionBSC(){
        return $this->hasOne('App\Models\Insttution\InstitutionBSC');
    }
}
