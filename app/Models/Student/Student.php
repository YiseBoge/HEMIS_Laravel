<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null name
 * @property array|string|null student_id
 * @property array|string|null phone_number
 * @property array|string|null birth_date
 * @property array|string|null sex
 * @property array|string|null remarks
 * @property int student_service_id
 * @property StudentService studentService
 */
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
