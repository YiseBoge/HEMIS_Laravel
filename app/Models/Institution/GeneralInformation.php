<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class GeneralInformation extends Model
{
    use Uuids;

    public $incrementing = false;
}
