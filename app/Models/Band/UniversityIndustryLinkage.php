<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null year
 * @property array|string|null number_of_industry_links
 * @property array|string|null number_of_students
 * @property array|string|null training_area
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

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
