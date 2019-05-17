<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

//    protected $enumSemesters = [
//        'ONE' => 'one',
//        'TWO' => 'two',
//        'SUMMER' => 'summer',
//    ];


    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function institutions()
    {
        return $this->hasMany('App\Models\Institution\Institution');
    }

    public function __toString()
    {
        return "Year $this->year, Semester $this->semester";
    }
}
