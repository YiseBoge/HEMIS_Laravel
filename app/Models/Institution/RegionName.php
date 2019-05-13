<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class RegionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function emergingRegion()
    {
        return $this->hasOne('App\Models\Institution\EmergingRegion');
    }

    public function pastoralRegion()
    {
        return $this->hasOne('App\Models\Institution\PastoralRegion');
    }
}


