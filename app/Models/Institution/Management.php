<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumManagementLevels = [
        'TOP_LEVEL' => 'Top Level',
        'MIDDLE_LEVEL' => 'Middle Level',
        'LOWER_LEVEL' => 'Lower Level'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
   
}
