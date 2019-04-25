<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StudentService extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumFoodServiceTypes = [
        'IN_KIND' => 'in_kind',
        'IN_CASH' => 'in_kind',
    ];


    // Enums //

    public function dormitoryService()
    {
        return $this->hasOne('App\Models\Student\DormitoryService');
    }
}
