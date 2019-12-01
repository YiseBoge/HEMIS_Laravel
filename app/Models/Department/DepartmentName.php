<?php

namespace App\Models\Department;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null department_name
 * @property string|null acronym
 * @property Uuid college_name_id
 * @property Uuid band_name_id
 * @property Collection users
 * @method static DepartmentName findOrFail(int $id)
 */
class DepartmentName extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (DepartmentName $model) { // before delete() method call this
            $model->department()->delete();
            $model->users()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function department()
    {
        return $this->hasMany('App\Models\Department\Department');
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function collegeName()
    {
        return $this->belongsTo('App\Models\College\CollegeName');
    }

    /**
     * @return BelongsTo
     */
    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    /**
     * @param Collection $collegeNames
     * @param Collection $bandNames
     * @return DepartmentName[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function byCollegeNamesAndBandNames(Collection $collegeNames, Collection $bandNames)
    {
        return DepartmentName::all()->whereIn('college_name_id', $collegeNames->pluck('id'))->whereIn('band_name_id', $bandNames->pluck('id'))->values();
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return DepartmentName::where(array(
                'acronym' => $this->acronym,

                'college_name_id' => $this->college_name_id,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->department_name";
    }
}
