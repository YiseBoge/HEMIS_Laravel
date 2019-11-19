<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null job_title
 * @property string|null staff_type
 * @property string|null level
 * @method static JobTitle find(int $id)
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
        'Level 1' => 'Level 1',
        'Level 2' => 'Level 2',
        'Level 3' => 'Level 3',
        'Level 4' => 'Level 4',
        'Level 5' => 'Level 5',
        'Level 6' => 'Level 6',
        'Level 7' => 'Level 7',
        'Level 8' => 'Level 8',
        'Level 9' => 'Level 9',
        'Level 10' => 'Level 10',
        'Level 11' => 'Level 11',
        'Level 12' => 'Level 12',
        'Level 13' => 'Level 13',
        'Level 14' => 'Level 14',
        'Level 15' => 'Level 15',
        'Level 16' => 'Level 16',
        'Level 17' => 'Level 17',
        'Level 18' => 'Level 18',
        'Level 19' => 'Level 19',
        'Level 20' => 'Level 20',
        'Level 21' => 'Level 21',
        'Level 22' => 'Level 22',
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

    public function isDuplicate()
    {
        return JobTitle::where(array(
                'job_title' => $this->job_title,
            ))->first() != null;
    }
}
