<?php

namespace App;

use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null name
 * @property array|string|null email
 * @property string password
 * @property DepartmentName departmentName
 * @property Instance currentInstance
 * @property CollegeName collegeName
 * @property mixed institution_name_id
 * @property mixed college_name_id
 * @property InstitutionName institutionName
 * @property uuid instance_id
 * @property uuid department_name_id
 * @property bool read_only
 * @method static User findOrFail(int $id)
 */
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
        'name', 'email', 'institution_id', 'password',
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

    /**
     * @return Institution|HasMany|object
     */
    public function institution()
    {
        $currentInstanceId = $this->currentInstance->id;
        $institution = $this->institutionName->institutions()->where('instance_id', $currentInstanceId)->first();

        return $institution;
    }

    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName', 'institution_name_id');
    }

    /**
     * @return BelongsTo
     */
    public function bandName()
    {
        return $this->departmentName->bandName();
    }

    public function collegeName()
    {
        return $this->belongsTo('App\Models\College\CollegeName', 'college_name_id');
    }

    public function departmentName()
    {
        return $this->belongsTo('App\Models\Department\DepartmentName', 'department_name_id');
    }

    public function currentInstance()
    {
        return $this->belongsTo('App\Models\Institution\Instance', 'instance_id');
    }

    private static function adminUser()
    {
        foreach (User::all() as $user) {
            if ($user->hasRole('Super Admin')) return $user;
        }
    }

    public static function adminInstance()
    {
        return self::adminUser()->currentInstance;
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

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('role_name', $roles)->first();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function comment(){
        return $this->hasMany('App\Models\Comment');
    }
    
    public function hasRole($role)
    {
        return null !== $this->roles()->where('role_name', $role)->first();
    }

    public function __toString()
    {
        return $this->name;
    }
}
