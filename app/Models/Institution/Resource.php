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
 * @property int number_of_classrooms
 * @property int number_of_smart_classrooms
 * @property int unjustifiable_expenses
 */
class Resource extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStatusOfLibraries = [
        'VERY_GOOD' => 'Very Good',
        'GOOD' => 'Good',
        'POOR' => 'Poor',
    ];

    protected $enumStatusOfLaboratories = [
        'VERY_GOOD' => 'Very Good',
        'GOOD' => 'Good',
        'POOR' => 'Poor',
    ];

    protected $enumStatusOfWorkshops = [
        'VERY_GOOD' => 'Very Good',
        'GOOD' => 'Good',
        'POOR' => 'Poor',
    ];
}
