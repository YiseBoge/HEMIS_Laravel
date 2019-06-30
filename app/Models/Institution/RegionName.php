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

    public function specialRegionEnrollment()
    {
        return $this->hasMany('App\Models\Department\SpecialRegionEnrollment');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}


