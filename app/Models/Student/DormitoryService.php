<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null dormitory_service_type
 * @property array|string|null block
 * @property array|string|null room_no
 */
class DormitoryService extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    // Enums //
    protected $enumDormitoryServiceTypes = [
        'IN_KIND' => 'In Kind',
        'IN_CASH' => 'In Cash',
    ];

    public function studentService()
    {
        return $this->hasOne('App\Models\Student\StudentService');
    }
}
