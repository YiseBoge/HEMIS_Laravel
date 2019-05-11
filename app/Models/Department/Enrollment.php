<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStudentTypes = [
        'PROSPECTIVE' => 'Prospective',
        'GRADUATES' => 'Graduates',
        'PREVIOUSLY_GRADUATED'=>'Previously Graduated',
        'Normal'=>'Normal'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

}
