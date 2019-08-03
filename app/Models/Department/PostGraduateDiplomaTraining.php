<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int number_of_male_students
 * @property int number_of_female_students
 * @property int is_lead
 * @method static PostGraduateDiplomaTraining find(int $id)
 */
class PostGraduateDiplomaTraining extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumTypes = [
        'NORMAL' => 'Normal',
        'LEADER' => 'School Leaders',
    ];

    protected $enumPrograms = [
        'REGULAR' => 'Regular',
        'NON_REGULAR' => 'Non Regular',
    ];

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return PostGraduateDiplomaTraining::where(array(
                'department_id' => $this->department_id,
                'is_lead' => $this->is_lead,
            ))->first() != null;
    }

}
