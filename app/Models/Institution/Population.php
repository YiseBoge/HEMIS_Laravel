<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null age_range
 * @property integer male_number
 * @property integer female_number
 * @method static Population find(int $id)
 */
class Population extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    protected $enumAgeRanges = [
        'BELOW_18' => 'Bellow 19',
        '18_23' => '19 - 23',
        '24_30' => '24 - 30',
        '31_40' => '31 - 40',
        '41_50' => '41 - 50',
        'ABOVE_50' => 'Above 50',
    ];


    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return Population::where(array(
                'age_range' => $this->age_range,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->male_number Males and $this->female_number Females at ages $this->age_range";
    }
}
