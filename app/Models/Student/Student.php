<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    public function studentService(){
        return $this->hasOne('App\Models\Student\StudentService');
    }

    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
    ];
}
