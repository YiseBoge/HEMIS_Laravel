<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use Uuids;

    public $incrementing = false;
}