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

    public function institutions(){
        return $this->hasMany('App\Models\Institution\Institution');
    }


    // Enums //
    protected $enumSemesters = [
        'ONE' => 'one',
        'TWO' => 'two',
        'SUMMER' => 'summer',
    ];
}