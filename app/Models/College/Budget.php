<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null budget_type
 * @property int allocated_budget
 * @property int additional_budget
 * @property int utilized_budget
 * @property string|null approval_status
 * @method static Budget where(string $string, $budget_type)
 * @method Budget get()
 * @method static Budget find($id)
 */
class Budget extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumBudgetTypes = [
        'CAPITAL' => 'Capital Budget',
        'RECURRENT' => 'Recurrent Budget',
    ];


    // Enums //

    /**
     * @return BelongsTo
     */
    public function budgetDescription()
    {
        return $this->belongsTo('App\Models\College\BudgetDescription');
    }

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
