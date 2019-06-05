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
    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
    ];

    public function studentService()
    {
        return $this->belongsTo('App\Models\Student\StudentService');
    }
}
