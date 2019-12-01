<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null name
 * @property Uuid student_id
 * @property string|null sex
 * @property string|null field_of_study
 * @property string|null tin_number
 * @property string|null receipt_number
 * @property DateTime registration_date
 * @property DateTime clearance_date
 * @property int tuition_fee
 * @property int food_expense
 * @property int dormitory_expense
 * @property int pre_payment_amount
 * @property int unpaid_amount
 * @method static CostSharing findOrFail(int $id)
 */
class CostSharing extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
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
        return $query->with('department.college', 'department.departmentName');
    }

    public function isDuplicate()
    {
        return CostSharing::where(array(
                'department_id' => $this->department_id,
                'student_id' => $this->student_id,
            ))->first() != null;
    }
}
