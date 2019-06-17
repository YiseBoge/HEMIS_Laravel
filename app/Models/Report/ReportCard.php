<?php

namespace App\Models\Report;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumKpis = [
        '1.1.1' => 'Improve access & equity',
    ];

    public function reportYearValues()
    {
        return $this->hasMany('App\Models\Report\ReportYearValue');
    }
}
