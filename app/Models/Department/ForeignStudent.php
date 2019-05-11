<?php

namespace App;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ForeignStudent extends Model
{
    
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumPrograms = [
        'REGULAR' => 'Regular',
        'NON_REGULAR' => 'Non Regular',
    ];

    protected $enumReasons = [
        'BIL_AGR' => 'Bilateral Agreement',
        'REFUGIES' => 'Refugies',
        'SCHOLARSHIPS' => 'Scholarships'
    ];

    public function department(){
        return $this->belongsTo('App\Model\Department\Department');
    }
}
