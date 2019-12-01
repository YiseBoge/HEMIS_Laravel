<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null revenue_description
 * @property string|null income
 * @property string|null expense
 * @property Uuid college_id
 * @method static InternalRevenue findOrFail(int $id)
 */
class InternalRevenue extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumRevenueDescriptions = [
        'FARMING' => 'Farming',
        'EDUCATION_PROGRAMS_TUITION_FEE' => 'Education Programs Tuition Fee',
        'TRAINING_AND_CONSULTANCY' => 'Training and Consultancy',
        'BUSINESS_ENTITIES' => 'Business Entities',
        'FUNDS' => 'Funds',
        'HOSPITAL_SERVICES' => 'Hospital Services',
    ];

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
        return InternalRevenue::where(array(
                'college_id' => $this->college_id,
                'revenue_description' => $this->revenue_description,
            ))->first() != null;
    }
}
