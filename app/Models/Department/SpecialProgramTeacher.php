<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int male_number
 * @property int female_number
 * @property string|null program_stat
 * @property string|null program_type
 * @method static SpecialProgramTeacher find(int $id)
 */
class SpecialProgramTeacher extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumProgramTypes = [
        'English LANGUAGE IMPROVEMENT PROGRAM' => 'English Language Improvement Program',
        'COMPREHENSIVE CONTINUOUS PROFESSIONAL DEVELOPMENT' => 'Comprehensive Continuous Professional Development',
        'HIGHER DIPLOMA PROGRAM' => 'Higher Diploma Program'
    ];

    protected $enumProgramStats = [
        'COMPLETED' => 'Completed',
        'ON TRAINING' => 'On Training',
        'NOT YET STARTED' => 'Not Yet Started'
    ];

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInfo($query)
    {
        return $query->with('department.College.band', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return SpecialProgramTeacher::where(array(
                'department_id' => $this->department_id,
                'program_stat' => $this->program_stat,
                'program_type' => $this->program_type,
            ))->first() != null;
    }
}
