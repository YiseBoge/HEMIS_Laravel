<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

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
