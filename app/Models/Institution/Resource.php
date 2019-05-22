<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use Uuids;

    public $incrementing = false;
}
