<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InternalRevenue extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumRevenueDescriptions = [
        'FARMING' => 'Farming',
        'EDUCATION_PROGRAMS_TUITION_FEE' => 'Education Programs Tuition Fee',
        'TRAINING_AND_CONSULTANCY' => 'Training and Consultancy',
        'BUSINESS_ENTITIES' => 'Business Entities',
        'FUNDS' => 'Funds',
        'HOSPITAL_SERVICES' => 'Hospital Services',
    ];

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
