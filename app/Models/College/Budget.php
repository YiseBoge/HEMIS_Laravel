<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null budget_type
 * @property array|string|null allocated_budget
 * @property array|string|null additional_budget
 * @property array|string|null utilized_budget
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

    public function budgetDescription()
    {
        return $this->belongsTo('App\Models\College\BudgetDescription');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
