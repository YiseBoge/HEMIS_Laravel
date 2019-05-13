<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class PostGraduateDiplomaTraining extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumPrograms = [
        'REGULAR' => 'Regular',
        'NON_REGULAR' => 'Non Regular',
    ];

    public function department(){
        return $this->belongsTo('App\Model\Department\Department');
    }
    
}
