<?php

namespace App\Models;

use App\Traits\Uuids;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class SupportContact extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

    }

    protected $fillable = ['name', 'phone'];

}
