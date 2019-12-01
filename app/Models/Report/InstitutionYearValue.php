<?php

namespace App\Models\Report;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property int year
 * @property int value
 * @property string type
 * @property Uuid institution_name_id
 * @property Uuid institution_report_card_id
 * @method static InstitutionYearValue findOrFail(int $id)
 */
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
