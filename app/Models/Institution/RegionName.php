<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(string $string, array|string|null $input)
 * @property array|string|null name
 */
class RegionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function emergingRegion()
    {
        return $this->hasOne('App\Models\Institution\EmergingRegion');
    }

    public function pastoralRegion()
    {
        return $this->hasOne('App\Models\Institution\PastoralRegion');
    }
}


