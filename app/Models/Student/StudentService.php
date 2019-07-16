<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null food_service_type
 * @property DormitoryService dormitoryService
 */
class StudentService extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(StudentService $model) { // before delete() method call this
            $model->dormitoryService()->delete();
        });
    }

    protected $enumFoodServiceTypes = [
        'IN_KIND' => 'In Kind',
        'IN_CASH' => 'In Cash',
    ];


    /**
     * @return BelongsTo
     */
    public function dormitoryService()
    {
        return $this->belongsTo('App\Models\Student\DormitoryService');
    }

    /**
     * @return HasOne
     */
    public function student()
    {
        return $this->hasOne('App\Models\Student\Student');
    }
}
