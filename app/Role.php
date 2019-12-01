<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property Collection users
 * @method static Collection where(string $string, string $string1)
 */
class Role extends Model
{
    use Uuids;

    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }

    public function __toString()
    {
        return $this->role_name;
    }
}
