<?php

namespace App\Models\MoSHE;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
class MoSHEBSC extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;

    protected $enumCategories = [
        'CAT-I' => 'Improve access & equity',
        'CAT-II' => 'Improve internal efficiency',
        'CAT-III' => 'Improve quality & relevance of education',
        'CAT-IV' => 'Improve quality & relevance of research',
        'CAT-V' => 'Promote diversity in higher education institutions',
        'CAT-VI' => 'Improve internationalization',
        'CAT-VII' => 'Improve resources mobilization',
    ];

    public function BSCInfo(){
        return $this->hasMany('App\Models\MoSHE\BSCInfo');
    }
}
