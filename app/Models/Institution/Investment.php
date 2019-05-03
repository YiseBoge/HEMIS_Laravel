<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumInvestmentTitles = [
        'BUILDINGS' => 'Buildings',
        'VEHICLES' => 'Vehicles',
        'EQUIPMENTS' => 'Equipments',
        'FURNITURES' => 'Furnitures',
        'MACHINARIES_AND_PLANTS' => 'Machinaries and Plants',
        'EDUCATION_MATERIALS' => 'Education Materials',
        'OTHERS' => 'Others',
        
    ];
}
