<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null title
 * @property DateTime date_of_publication
 */
class StaffPublication extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function academicStaff()
    {
        return $this->belongsto('App\Models\Staff\AcademicStaff');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return StaffPublication::where(array(
                'academic_staff_id' => $this->academic_staff_id,
                'title' => $this->title,
            ))->first() != null;
    }
}
