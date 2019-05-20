<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class SpecialNeeds extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumNeedsTypes = [
        'PHYSICALLY_CHALLENGED_LEGS' => 'Physically Challenged (Legs)',
        'PHYSICALLY_CHALLENGED_HANDS' => 'Physically Challenged (Hands)',
        'VISUALLY_IMPAIRED'=>'Visually Impaired',
        'HEARING_IMPAIRED'=>'Hearing Impaired',
        'OTHERS' => 'Others'
    ];

    protected $enumYears=[
        'ONE'=>'1',
        'TWO'=>'2',
        'THREE'=>'3',
        'FOUR'=>'4',
        'FIVE'=>'5',
        'SIX'=>'6',
        'SEVEN'=>'7'
    ];

    protected $enumEducationPrograms=[
        'REGULAR'=>'Regular',
        'EXTENSION'=>'Extension',
        'SUMMER'=>'Summer',
        'DISTANCE'=>'Distance'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }


}
