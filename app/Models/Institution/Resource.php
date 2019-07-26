<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int number_of_libraries
 * @property int number_of_laboratories
 * @property int number_of_workshops
 * @property string|null status_of_libraries
 * @property string|null status_of_laboratories
 * @property string|null status_of_workshops
 * @property int pupil_per_teacher
 * @property int text_per_student
 * @property int rate_of_smart_classrooms
 */
class Resource extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStatusOfLibraries = [
        'UNKNOWN' => 'Unknown'
    ];

    protected $enumStatusOfLaboratories = [
        'UNKNOWN' => 'Unknown'
    ];

    protected $enumStatusOfWorkshops = [
        'UNKNOWN' => 'Unknown'
    ];
}
