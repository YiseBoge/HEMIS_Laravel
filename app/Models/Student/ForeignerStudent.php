<?php

namespace App\Models\Student;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ForeignerStudent extends Model
{
    use Uuids;

    public $incrementing = false;

    public function general(){
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }
}
