<?php

namespace App\Models\College;

use App\Models\Band\BandName;
use App\Models\Department\DepartmentName;
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
 * @property BandName bandName
 * @property DepartmentName departmentNames
 * @property Uuid institution_name_id
 * @property Uuid band_name_id
 * @method static CollegeName find(int $id)
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
     * @param Collection $bandNames
     * @return Collection
     */
    public static function byInstitutionNamesAndBandNames(Collection $institutionNames, Collection $bandNames)
    {
        return CollegeName::all()->whereIn('institution_name_id', $institutionNames->pluck('id'))
            ->whereIn('band_name_id', $bandNames->pluck('id'))->values();
    }

    /**
     * @return HasMany
     */
    public function departmentNames()
    {
        return $this->hasMany('App\Models\Department\DepartmentName');
    }

    /**
     * @return BelongsTo
     */
    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
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
                'band_name_id' => $this->band_name_id,
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
