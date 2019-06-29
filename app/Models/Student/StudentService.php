<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null food_service_type
 * @property DormitoryService dormitoryService
 */
class StudentService extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumFoodServiceTypes = [
        'IN_KIND' => 'In Kind',
        'IN_CASH' => 'In Cash',
    ];

    // Enums //
    public function dormitoryService()
    {
        return $this->belongsTo('App\Models\Student\DormitoryService');
    }

    public function student()
    {
        return $this->hasOne('App\Models\Student\Student');
    }
}
