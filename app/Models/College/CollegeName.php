<?php

namespace App\Models\College;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null college_name
 * @property string|null acronym
 * @method static CollegeName find(int $id)
 */
class CollegeName extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return HasOne
     */
    public function college()
    {
        return $this->hasOne('App\Models\College\College');
    }

    /**
     * @return string
     */
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
