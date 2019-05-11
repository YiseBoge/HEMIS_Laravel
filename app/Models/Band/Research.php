<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStatus=[
        'ONGOING'=>'On Going',
        'COMPLETED'=>'Completed'
    ];

    protected $enumTypes=[
        'NORMAL'=>'Normal',
        'THEMATIC'=>'Thematic'
    ];

    public function band()
    {
        return $this->belongsTo('App\Models\Band\Band');
    }

}
