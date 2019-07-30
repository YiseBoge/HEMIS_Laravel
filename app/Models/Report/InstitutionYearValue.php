<?php

namespace App\Models\Report;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionYearValue extends Model
{
    use Uuids;
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function reportCard()
    {
        return $this->belongsTo('App\Models\Report\InstitutionReportCard');
    }

    /**
     * @return BelongsTo
     */
    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName');
    }
}
