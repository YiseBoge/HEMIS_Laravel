<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BudgetDescription extends Model
{
    use Uuids;

    public function institution(){
        return $this->hasOne('App\Models\Institution\Institution');
    }

    public $incrementing = false;
}
