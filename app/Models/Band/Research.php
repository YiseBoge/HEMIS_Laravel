<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null number
 * @property array|string|null male_teachers_participating_number
 * @property array|string|null female_teachers_participating_number
 * @property array|string|null female_researchers_number
 * @property array|string|null male_researchers_other_number
 * @property array|string|null female_researchers_other_number
 * @property array|string|null budget_allocated
 * @property array|string|null budget_from_externals
 * @property array|string|null status
 * @property array|string|null type
 */
class Research extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumCompletions = [
        'ONGOING' => 'On Going',
        'COMPLETED' => 'Completed'
    ];

    protected $enumTypes = [
        'NORMAL' => 'Normal',
        'THEMATIC' => 'Thematic'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

}
