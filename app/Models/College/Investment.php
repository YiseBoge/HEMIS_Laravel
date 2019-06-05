<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumInvestmentTitles = [
        'BUILDINGS' => 'Buildings',
        'VEHICLES' => 'Vehicles',
        'EQUIPMENTS' => 'Equipments',
        'FURNITURES' => 'Furnitures',
        'MACHINARIES_AND_PLANTS' => 'Machinaries and Plants',
        'EDUCATION_MATERIALS' => 'Education Materials',
        'OTHERS' => 'Others',
    ];

    // Enums //

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
