<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

class QualifiedInternship extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumSponsorTypes = [
        'COMPANY_SPONSORED' => 'Company Sponsored',
        'NON_COMPANY_SPONSORED' => 'Non-Company Sponsored'

    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return QualifiedInternship::where(array(
                'department_id' => $this->department_id,
                'sponsor_type' => $this->sponsor_type,
            ))->first() != null;
    }
}
