<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Instance orderByDesc(string $string)
 * @method Collection get()
 * @method static Instance where(string $string, $year)
 * @method static Instance find(int $id)
 * @property string|null year
 * @property string|null semester
 */
class Instance extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (Instance $model) { // before delete() method call this
            $model->users()->delete();
            $model->institutions()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return HasMany
     */
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution\Institution');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Year $this->year, Semester $this->semester";
    }
}
