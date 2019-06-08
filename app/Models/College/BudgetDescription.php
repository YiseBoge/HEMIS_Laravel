<?php

namespace App\Models\College;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BudgetDescription extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function findByBudgetCode($code)
    {
        return BudgetDescription::where('budget_code', $code)->get()->first();
    }

    public function budget()
    {
        return $this->hasMany('App\Models\College\Budget');
    }

    public function __toString()
    {
        return $this->budget_code . ' - ' . $this->description;
    }
}

