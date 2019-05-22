<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institution()
    {
        return $this->hasOne('App\Models\Institution\Institution');
    }

    public function budget()
    {
        return $this->belongsTo('App\Models\Institution\Budget');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Institution\Resource');
    }

    public function communityService()
    {
        return $this->belongsTo('App\Models\Institution\CommunityService');
    }
}
