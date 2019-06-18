<?php

namespace App\Models\Report;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ReportYearValue extends Model
{
    use Uuids;
    public $incrementing = false;

    public function reportCard()
    {
        return $this->belongsTo('App\Models\Report\ReportCard');
    }
}
