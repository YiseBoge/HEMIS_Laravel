<?php

namespace App\Models\Band;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null band_name
 * @property array|string|null acronym
 */
class BandName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function band()
    {
        return $this->hasOne('App\Models\Band\Band');
    }

    public function __toString()
    {
        return "$this->acronym - $this->band_name";
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
