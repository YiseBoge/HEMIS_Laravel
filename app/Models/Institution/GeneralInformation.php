<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property CommunityService communityService
 * @property Resource resource
 * @property array|string|null campuses
 * @property array|string|null colleges
 * @property array|string|null schools
 * @property array|string|null institutes
 * @property array|string|null board_members
 * @property array|string|null vice_presidents
 * @property array|string|null middle_level_leaders
 */
class GeneralInformation extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institution()
    {
        return $this->hasOne('App\Models\Institution\Institution');
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
