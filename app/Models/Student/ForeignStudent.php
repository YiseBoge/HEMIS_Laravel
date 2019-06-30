<?php

namespace App\Models\Student;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null nationality
 * @property int years_in_ethiopia
 * @property Student general
 * @method static ForeignStudent find($id)
 */
class ForeignStudent extends Model
{
    use Uuids;
    public $incrementing = false;

    /**
     * @return MorphOne
     */
    public function general()
    {
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInfo($query)
    {
        return $query->with('general.studentService.dormitoryService', 'department.departmentName');
    }
}
