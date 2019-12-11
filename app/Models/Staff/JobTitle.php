<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null job_title
 * @property string|null staff_type
 * @property string|null level
 * @method static JobTitle findOrFail(int $id)
 * @method static Collection where(string $string, string $string1)
 */
class JobTitle extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStaffTypes = [
        'Academic' => 'Academic',
        'Administrative' => 'Administrative',
        'Technical' => 'Technical',
        'Management' => 'Management',
    ];
    protected $enumLevels = [
        'Level I' => 'Level I',
        'Level II' => 'Level II',
        'Level III' => 'Level III',
        'Level IV' => 'Level IV',
        'Level V' => 'Level V',
        'Level VI' => 'Level VI',
        'Level VII' => 'Level VII',
        'Level VIII' => 'Level VIII',
        'Level IX' => 'Level IX',
        'Level X' => 'Level X',
        'Level XI' => 'Level XI',
        'Level XII' => 'Level XII',
        'Level XIII' => 'Level XIII',
        'Level XIV' => 'Level XIV',
        'Level XV' => 'Level XV',
        'Level XVI' => 'Level XVI',
        'Level XVII' => 'Level XVII',
        'Level XVIII' => 'Level XVIII',
        'Level XIX' => 'Level XIX',
        'Level XX' => 'Level XX',
        'Level XXI' => 'Level XXI',
        'Level XXII' => 'Level XXII',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (JobTitle $model) { // before delete() method call this
            $model->academicStaffs()->delete();
            $model->administrativeStaffs()->delete();
        });
    }


    /**
     * @return HasMany
     */
    public function academicStaffs()
    {
        return $this->hasMany('App\Models\Staff\AcademicStaff');
    }

    /**
     * @return HasMany
     */
    public function administrativeStaffs()
    {
        return $this->hasMany('App\Models\Staff\AdministrativeStaff');
    }

    /**
     * @return HasMany
     */
    public function managementStaffs()
    {
        return $this->hasMany('App\Models\Staff\ManagementStaff');
    }

    /**
     * @return HasMany
     */
    public function technicalStaffs()
    {
        return $this->hasMany('App\Models\Staff\TechnicalStaff');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return JobTitle::where(array(
                'job_title' => $this->job_title,
            ))->first() != null;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return "$this->job_title ($this->level)";
    }
}
