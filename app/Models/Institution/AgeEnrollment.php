<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AgeEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumAge=[
        'UNDER18'=>'<18',
        'EIGHTEEN'=>'18',
        'NINETEEN'=>'19',
        'TWENTY'=>'20',
        'TWENTY_ONE'=>'21',
        'TWENTY_TWO'=>'22',
        'TWENTY_THREE'=>'23',
        'TWENTY_FOUR'=>'24',
        'TWENTY_FIVE'=>'25',
        'TWENTY_SIX'=>'26',
        'ABOVE26'=>'>26'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }


}