<?php

namespace App\Models\College;

use App\Models\Department\DepartmentName;
use App\Models\Institution\InstitutionName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null college_name
 * @property string|null acronym
 * @property DepartmentName departmentNames
 * @property Uuid institution_name_id
 * @property InstitutionName institutionName
 * @method static CollegeName findOrFail(int $id)
 */
class CollegeName extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (CollegeName $model) { // before delete() method call this
            $model->departmentNames()->delete();
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
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @param Collection $institutionNames
     * @return Collection
     */
    public static function byInstitutionNames(Collection $institutionNames)
    {
        return CollegeName::all()->whereIn('institution_name_id', $institutionNames->pluck('id'))->values();
    }

    /**
     * @return BelongsTo
     */
    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName');
    }

    /**
     * @return HasMany
     */
    public function departmentNames()
    {
        return $this->hasMany('App\Models\Department\DepartmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return CollegeName::where(array(
                'college_name' => $this->college_name,
                'acronym' => $this->acronym,

                'institution_name_id' => $this->institution_name_id,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->college_name";
    }
}
