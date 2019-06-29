<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null title
 * @property array|string|null date_of_publication
 */
class StaffPublication extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function academicStaff()
    {
        return $this->belongsto('App\Models\Staff\AcademicStaff');
    }
}
