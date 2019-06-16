<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumStatusOfLibraries = [
        'UNKNOWN' => 'Unknown'
    ];

    protected $enumStatusOfLaboratories = [
        'UNKNOWN' => 'Unknown'
    ];

    protected $enumStatusOfWorkshops = [
        'UNKNOWN' => 'Unknown'
    ];
}
