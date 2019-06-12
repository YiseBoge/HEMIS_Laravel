<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use Uuids;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','institution_id', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function institution()
    {
        $currentInstanceId = $this->currentInstance->id;
        $institution = $this->institutionName->institutions()->where('instance_id', $currentInstanceId)->first();

//        return array_intersect ( $this->currentInstance->institutions, $this->institutionName->institutions);
        return $institution;
    }

    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName', 'institution_name_id');
    }

    public function collegeName()
    {
        return $this->belongsTo('App\Models\College\CollegeName', 'college_name_id');
    }

    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName', 'band_name_id');
    }

    public function departmentName()
    {
        return $this->belongsTo('App\Models\Department\DepartmentName', 'department_name_id');
    }

    public function currentInstance()
    {
        return $this->belongsTo('App\Models\Institution\Instance', 'instance_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('role_name', $role)->first();
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('role_name', $roles)->first();
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }

    public function __toString()
    {
        return $this->name;
    }
}
