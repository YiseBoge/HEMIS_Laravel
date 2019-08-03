<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null year
 * @property int number_of_industry_links
 * @property int number_of_students
 * @property int training_area
 * @method static UniversityIndustryLinkage find(int $id)
 */
class UniversityIndustryLinkage extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumYears = [
        'ONE' => '1',
        'TWO' => '2',
        'THREE' => '3',
        'FOUR' => '4',
        'FIVE' => '5',
        'SIX' => '6',
        'SEVEN' => '7'
    ];

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return UniversityIndustryLinkage::where(array(
                'college_id' => $this->college_id,
                'year' => $this->year,
                'training_area' => $this->training_area,
            ))->first() != null;
    }
}
