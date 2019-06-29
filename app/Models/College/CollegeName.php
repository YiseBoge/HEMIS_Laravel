<?php

namespace App\Models\College;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null college_name
 * @property array|string|null acronym
 */
class CollegeName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function college()
    {
        return $this->hasOne('App\Models\College\College');
    }

    public function __toString()
    {
        return "$this->acronym - $this->college_name";
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
