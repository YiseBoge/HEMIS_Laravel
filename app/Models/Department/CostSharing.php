<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null name
 * @property array|string|null student_id
 * @property array|string|null sex
 * @property array|string|null field_of_study
 * @property array|string|null tin_number
 * @property array|string|null receipt_number
 * @property array|string|null registration_date
 * @property array|string|null clearance_date
 * @property array|string|null tuition_fee
 * @property array|string|null food_expense
 * @property array|string|null dormitory_expense
 * @property array|string|null pre_payment_amount
 * @property array|string|null unpaid_amount
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

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }
}
