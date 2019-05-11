<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    
    use Uuids;
    use Enums;

    public $incrementing = false;
}
