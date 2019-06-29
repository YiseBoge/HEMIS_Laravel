<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int number
 * @property int male_teachers_participating_number
 * @property int female_teachers_participating_number
 * @property int female_researchers_number
 * @property int male_researchers_other_number
 * @property int female_researchers_other_number
 * @property int budget_allocated
 * @property int budget_from_externals
 * @property string|null status
 * @property string|null type
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

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

}
