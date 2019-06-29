<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(string $string, $purposeString)
 */
class BuildingPurpose extends Model
{
    use Uuids;

    public $incrementing = false;

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Institution\Building', 'building_building_purpose', 'building_purpose_id', 'building_id');
    }

    public function __toString()
    {
        return $this->purpose;
    }
}
