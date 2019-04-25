<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InstitutionName extends Model
{
    use Uuids;

    public function institution(){
        return $this->hasOne('App\Models\Band\Band');
    }

    public $incrementing = false;
}