<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationLevels = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
    protected $enumEducationPrograms = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];


    // Enums //

    public function bandName()
    {
        return $this->hasOne('App\Models\Band\BandName');
    }

    public function departments()
    {
        return $this->hasMany('App\Models\Department\Department');
    }
}
