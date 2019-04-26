<?php

namespace App\Models\Student;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class DisabledStudent extends Model
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


    // Enums //

    public function general()
    {
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }
}
