<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(array $array)
 * @method static PublicationsAndPatents find(int $id)
 * @property array|string|null student_publications
 * @property array|string|null patents
 */
class PublicationsAndPatents extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function department()
    {
        return $this->belongsto('App\Models\Department\Department');
    }
}
