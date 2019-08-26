<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Comment extends Model
{
    use Uuids;
    public $incrementing = false; 

    protected $casts = [
        'created_at' => 'date:Y-m-d H:00'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
