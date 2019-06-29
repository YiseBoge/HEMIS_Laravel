<?php

namespace App\Models\Band;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null band_name
 * @property string|null acronym
 */
class BandName extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return HasOne
     */
    public function band()
    {
        return $this->hasOne('App\Models\Band\Band');
    }

    /**
     * @return string
     */
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
