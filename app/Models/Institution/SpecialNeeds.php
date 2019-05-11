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
        'PHYSICALLY_CHALLENGED_LEGS' => 'physically challenged /legs/',
        'PHYSICALLY_CHALLENGED_HANDS' => 'physically challenged /hands/',
        'VISUALLY_IMPAIRED'=>'visually impaired',
        'HEARING_IMPAIRED'=>'hearing_impaired',
        'OTHERS'=>'others'
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

    protected $enumPrograms=[
        'REGULAR'=>'regular',
        'SUMMER'=>'summer',
        'DISTANCE'=>'distance'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }


}
