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
        'IN_KIND' => 'in_kind',
        'IN_CASH' => 'in_kind',
    ];
}
