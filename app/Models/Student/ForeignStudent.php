<?php

namespace App\Models\Student;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null nationality
 * @property array|string|null years_in_ethiopia
 * @property Student general
 * @method static ForeignStudent find($id)
 */
class ForeignStudent extends Model
{
    use Uuids;
    public $incrementing = false;

    public function general()
    {
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {

        return $query->with('general.studentService.dormitoryService', 'department.departmentName');

    }
}
