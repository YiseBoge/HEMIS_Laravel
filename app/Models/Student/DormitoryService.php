<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null dormitory_service_type
 * @property string|null block
 * @property string|null room_no
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

    /**
     * @return HasOne
     */
    public function studentService()
    {
        return $this->hasOne('App\Models\Student\StudentService');
    }
}
