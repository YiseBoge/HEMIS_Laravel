<?php

namespace App\Models\Band;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BandName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function band()
    {
        return $this->hasOne('App\Models\Band\Band');
    }

    public function __toString()
    {
        return "$this->acronym - $this->band_name";
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
