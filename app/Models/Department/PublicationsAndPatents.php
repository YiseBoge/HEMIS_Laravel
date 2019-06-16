<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class PublicationsAndPatents extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function department()
    {
        return $this->belongsto('App\Models\Department\Department');
    }
}
