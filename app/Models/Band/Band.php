<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(array $array)
 * @property int band_name_id
 */
class Band extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //

    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    public function colleges()
    {
        return $this->hasMany('App\Models\College\College');
    }

    public function technicalStaffs()
    {
        return $this->hasMany('App\Models\College\TechnicalStaff');
    }
}
