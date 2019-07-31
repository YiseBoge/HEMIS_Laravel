<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int required
 * @property int assigned
 * @property int female_number
 * @property array|string|null management_level
 */
class ManagementData extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumManagementLevels = [
        'SENIOR' => 'Senior',
        'MIDDLE' => 'Middle',
        'LOWER' => 'Lower'
    ];

    /**
     * @return BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
}
