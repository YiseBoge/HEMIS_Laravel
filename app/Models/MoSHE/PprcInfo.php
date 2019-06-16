<?php

namespace App\Models\MoSHE;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class PprcInfo extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumTypes = [
        'BASELINE' => 'Baseline',
        'REGULAR' => 'Regular',
        'TARGET' => 'Target',
    ];

    public function MohePprc(){
        return $this->hasOne('App\Models\MoSHE\MoshePprc');
    }
}
