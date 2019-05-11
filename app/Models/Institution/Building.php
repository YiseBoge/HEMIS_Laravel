<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
}
