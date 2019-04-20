<?php

namespace App\Models\Band;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BandName extends Model
{
    use Uuids;

    public function band(){
        return $this->hasOne('App\Models\Band\Band');
    }

    public $incrementing = false;
}
