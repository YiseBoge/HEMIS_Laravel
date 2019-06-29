<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(string $string, array|string|null $input)
 * @property string|null name
 */
class RegionName extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return HasOne
     */
    public function emergingRegion()
    {
        return $this->hasOne('App\Models\Institution\EmergingRegion');
    }

    /**
     * @return HasOne
     */
    public function pastoralRegion()
    {
        return $this->hasOne('App\Models\Institution\PastoralRegion');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}


