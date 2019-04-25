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
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];


    // Enums //

    public function general()
    {
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }
}
