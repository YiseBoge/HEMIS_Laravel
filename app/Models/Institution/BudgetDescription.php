<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BudgetDescription extends Model
{
    use Uuids;

    public $incrementing = false;

    public function budget()
    {
        return $this->hasMany('App\Models\Institution\Budget');
    }
}
