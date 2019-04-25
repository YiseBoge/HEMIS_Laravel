<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumBudgetTypes = [
        'CAPITAL' => 'capital',
        'RECURRENT' => 'recurrent',
    ];


    // Enums //

    public function budgetDescription()
    {
        return $this->hasOne('App\Models\Institution\BudgetDescription');
    }
}
