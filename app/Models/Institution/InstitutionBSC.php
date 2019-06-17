<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InstitutionBSC extends Model
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

    public function Institution(){
        return $this->belongsTo('App\Models\Institution\Institution');
    }

    public function InstitutionBSCInfo(){
        return $this->hasMany('App\Models\Institution\InstitutionBSCInfo');
    }
}
