<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null disability
 * @property Student general
 * @method static SpecialNeedStudent find($id)
 */
class SpecialNeedStudent extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumDisabilitys = [
        'VISUALLY_IMPAIRED' => 'Visiually Impaired',
        'HEARING_IMPAIRED' => 'Hearing Impaired',
        'PHYSICALLY_CHALLENGED' => 'Physically Challenged',
        'OTHERS' => 'Others',
    ];


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
