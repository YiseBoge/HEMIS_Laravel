<?php

namespace App\Models\College;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null budget_code
 * @property array|string|null description
 */
class BudgetDescription extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @param String $code
     * @return BudgetDescription
     */
    public static function findByBudgetCode($code)
    {
        return BudgetDescription::where('budget_code', $code)->get()->first();
    }

    /**
     * @return HasMany
     */
    public function budget()
    {
        return $this->hasMany('App\Models\College\Budget');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->budget_code . ' - ' . $this->description;
    }
}

