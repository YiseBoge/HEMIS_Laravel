<?php

namespace App\Models\Report;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 */
class ReportYearValue extends Model
{
    use Uuids;
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function reportCard()
    {
        return $this->belongsTo('App\Models\Report\ReportCard');
    }
}
