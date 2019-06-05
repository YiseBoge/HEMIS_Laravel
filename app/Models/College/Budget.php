<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

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
