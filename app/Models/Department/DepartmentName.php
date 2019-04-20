<?php

namespace App\Models\Department;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class DepartmentName extends Model
{
    use Uuids;

    public function department(){
        return $this->hasOne('App\Models\Department\Department');
    }

    public $incrementing = false;
}
