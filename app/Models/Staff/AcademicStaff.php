<?php

namespace App\Models\Staff;


use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null field_of_study
 * @property int teaching_load
 * @property string|null overload_remark
 * @property string|null staffRank
 * @property Uuid staff_leave_id
 * @property Staff general
 * @method static AcademicStaff find($id)
 * @method static Collection where(array $array)
 */
class AcademicStaff extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;
    protected $enumStaffRanks = [
        'GRADUATE_ASSISTANT_I' => 'Graduate Assistant I',
        'GRADUATE_ASSISTANT_II' => 'Graduate Assistant II',
        'ASSISTANT_LECTURER' => 'Assistant Lecturer',
        'LECTURER' => 'Lecturer',
        'ASSISTANT_PROFESSOR' => 'Assistant Professor',
        'ASSOCIATE_PROFESSOR' => 'Associate Professor',
        'PROFESSOR' => 'Professor',
        'OTHERS' => 'Others'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (AcademicStaff $model) { // before delete() method call this
            $model->general()->delete();
            $model->staffLeave()->delete();
            $model->publications()->delete();
        });
    }

    // Enums //

    /**
     * @return MorphOne
     */
    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    /**
     * @return BelongsTo
     */
    public function staffLeave()
    {
        return $this->belongsTo('App\Models\Staff\StaffLeave');
    }

    /**
     * @return HasMany
     */
    public function publications()
    {
        return $this->hasMany('App\Models\Staff\StaffPublication');
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
        if ($this->staff_leave_id == 0) {
            return $query->with('general');
        } else {
            return $query->with('general', 'staffLeave');
        }

    }
}
