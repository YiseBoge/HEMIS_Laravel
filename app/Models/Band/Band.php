<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //

    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    public function studentAttritions()
    {
        return $this->hasMany('App\Models\Band\StudentAttrition');
    }

    public function college()
    {
        return $this->hasMany('App\Models\College\College');
    }
}
