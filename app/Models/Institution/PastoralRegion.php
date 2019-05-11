<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class PastoralRegion extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance'
    ];

    protected $enumYears = [
        'ONE' => '1',
        'TWO' => '2',
        'THREE' => '3',
        'FOUR' => '4',
        'FIVE' => '5',
        'SIX' => '6',
        'SEVEN' => '7'
    ];

    public function regionName()
    {
        return $this->belongsTo('App\Models\Institution\RegionName');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
