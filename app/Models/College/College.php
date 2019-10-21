<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static College where(array $array)
 * @method College first()
 * @property string education_level
 * @property string education_program
 * @property int college_name_id
 * @property Uuid band_id
 * @property Collection departments
 */
class College extends Model
{

    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationLevels = [
        'UNDERGRADUATE' => 'Undergraduate',
        'POST_GRADUATE_MASTERS' => 'Post Graduate(Masters)',
        'POST_GRADUATE_PHD' => 'Post Graduate(PhD)',
        'POST_DOCTORAL' => 'Post Doctoral',
        'SPECIALIZATION' => 'Health Specialty',
        'NONE' => 'None'
    ];
    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance',
        'NONE' => 'None'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (College $model) { // before delete() method call this
            $model->departments()->delete();
            $model->budgets()->delete();
            $model->internalRevenues()->delete();
            $model->investments()->delete();
            $model->administrativeStaffs()->delete();
            $model->ictStaffs()->delete();
            $model->managementStaffs()->delete();
            $model->technicalStaffs()->delete();
            $model->universityIndustryLinkages()->delete();
            $model->buildings()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function departments()
    {
        return $this->hasMany('App\Models\Department\Department');
    }

    /**
     * @return HasMany
     */
    public function budgets()
    {
        return $this->hasMany('App\Models\College\Budget');
    }

    /**
     * @return HasMany
     */
    public function internalRevenues()
    {
        return $this->hasMany('App\Models\College\InternalRevenue');
    }

    /**
     * @return HasMany
     */
    public function investments()
    {
        return $this->hasMany('App\Models\College\Investment');
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
    public function ictStaffs()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
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
     * @return HasMany
     */
    public function universityIndustryLinkages()
    {
        return $this->hasMany('App\Models\Band\UniversityIndustryLinkage');
    }

    /**
     * @return HasMany
     */
    public function buildings()
    {
        return $this->hasMany('App\Models\Institution\Building');
    }

    /**
     * @param Collection $collegeNames
     * @param array $programs
     * @param array $levels
     * @return College[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function byCollegeNamesAndProgramsAndLevels(Collection $collegeNames, array $programs, array $levels)
    {
        return College::all()
            ->whereIn('college_name_id', $collegeNames->pluck('id'))
            ->whereIn('education_program', $programs)
            ->whereIn('education_level', $levels);
    }

    /**
     * @return BelongsTo
     */
    public function collegeName()
    {
        return $this->belongsTo('App\Models\College\CollegeName');
    }

    /**
     * @return HasMany
     */
    public function budgetsApproved()
    {
        return $this->hasMany('App\Models\College\Budget')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function internalRevenuesApproved()
    {
        return $this->hasMany('App\Models\College\InternalRevenue')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function investmentsApproved()
    {
        return $this->hasMany('App\Models\College\Investment')->where('approval_status', 'Approved');
    }

    /**
     * @return BelongsTo
     */
    public function band()
    {
        return $this->belongsTo('App\Models\Band\Band');
    }

    /**
     * @return HasMany
     */
    public function universityIndustryLinkagesApproved()
    {
        return $this->hasMany('App\Models\Band\UniversityIndustryLinkage')->where('approval_status', 'Approved');
    }

}
