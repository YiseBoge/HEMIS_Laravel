<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class TechnicalStaff extends Model
{

    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumEducationLevels = [
        'LEVEL_III' => 'Level III',
        'LEVEL_IV' => 'Level IV',
        'LEVEL_V' => 'Level V',
        'DIPLOMA' => 'Diploma',
        'ADVANCED_DIPLOMA' => 'Advanced Diploma',
        'BACHELORS' => 'Bachelors',
        'OTHERS' => 'Others'
    ];

    public function college(){
        return $this->belongsTo('App\Models\College\College');
    }

    
    
}
