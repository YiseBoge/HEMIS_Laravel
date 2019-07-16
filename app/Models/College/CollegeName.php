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

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(CollegeName $model) { // before delete() method call this
            $model->college()->delete();
            $model->users()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function college()
    {
        return $this->hasMany('App\Models\College\College');
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
