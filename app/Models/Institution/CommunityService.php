<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null community_services
 * @property array|string|null male_teachers_participated
 * @property array|string|null female_teachers_participated
 * @property array|string|null male_benefited
 * @property array|string|null female_benefited
 * @property int linked_tvets
 * @property bool has_spd
 * @property bool has_incubation
 * @property bool has_hdp_lead
 * @property bool has_ccpd_coordinator
 * @property bool has_elip_teachers
 * @property bool has_elip_students
 * @property bool has_career_center
 */
class CommunityService extends Model
{
    use Uuids;

    public $incrementing = false;
}
