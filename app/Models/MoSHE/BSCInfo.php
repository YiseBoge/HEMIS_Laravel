<?php

namespace App\Models\MoSHE;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BSCInfo extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumTypes = [
        'BASELINE' => 'Baseline',
        'CUURENT' => 'Current',
        'TARGET' => 'Target',
    ];

    public function MoSHEBSC(){
        return $this->hasOne('App\Models\MoSHE\MoSHEBSC');
    }
}
