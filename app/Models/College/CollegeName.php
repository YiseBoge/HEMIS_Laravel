<?php

namespace App\Models\College;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class CollegeName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function college()
    {
        return $this->hasOne('App\Models\College\College');
    }

    public function __toString()
    {
        return "$this->acronym - $this->college_name";
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
