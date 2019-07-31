<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null institution_name
 * @property string|null acronym
 * @property bool is_private
 * @property Collection collegeNames
 * @property Collection departmentNames
 * @method static InstitutionName find($id)
 */
class InstitutionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (InstitutionName $model) { // before delete() method call this
            $model->institutions()->delete();
            $model->collegeNames()->delete();
            $model->departmentNames()->delete();
            $model->users()->delete();
        });
    }

    public function yearValues()
    {
        return $this->hasMany('App\Models\Report\InstitutionYearValue');
    }

    /**
     * @return HasMany
     */
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution\Institution');
    }

    /**
     * @return HasMany
     */
    public function collegeNames()
    {
        return $this->hasMany('App\Models\College\CollegeName');
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return InstitutionName::where(array(
                'institution_name' => $this->institution_name,
                'acronym' => $this->acronym,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->institution_name";
    }
}
