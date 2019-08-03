<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null name
 * @property Uuid student_id
 * @property string|null phone_number
 * @property DateTime birth_date
 * @property string|null sex
 * @property string|null remarks
 * @property Uuid student_service_id
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

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (Student $model) { // before delete() method call this
            $model->studentService()->delete();
        });
    }

    /**
     * @return BelongsTo
     */
    public function studentService()
    {
        return $this->belongsTo('App\Models\Student\StudentService');
    }

    public function isDuplicate()
    {
        return Student::where(array(
                'student_id' => $this->student_id,
            ))->first() != null;
    }
}
