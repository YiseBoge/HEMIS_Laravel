<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null investment_title
 * @property string|null cost_incurred
 * @property string|null remarks
 * @property string|null approval_status
 * @property Uuid college_id
 * @method static Investment find(int $id)
 */
class Investment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumInvestmentTitles = [
        'BUILDINGS' => 'Buildings',
        'VEHICLES' => 'Vehicles',
        'EQUIPMENTS' => 'Equipments',
        'FURNITURES' => 'Furnitures',
        'MACHINARIES_AND_PLANTS' => 'Machinaries and Plants',
        'EDUCATION_MATERIALS' => 'Education Materials',
        'OTHERS' => 'Others',
    ];

    // Enums //

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return Budget::where(array(
                'college_id' => $this->college_id,
                'investment_title' => $this->investment_title,
            ))->first() != null;
    }
}
