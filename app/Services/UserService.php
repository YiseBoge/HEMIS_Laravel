<?php


namespace App\Services;


use App\Models\College\CollegeName;
use App\Models\Institution\CommunityService;
use App\Models\Institution\GeneralInformation;
use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\Resource;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @var Instance
     */
    private $instance;

    /**
     * UserService constructor.
     * @param Instance $instance
     */
    public function __construct(Instance $instance)
    {
        $this->instance = $instance;
    }

    /**
     *
     */
    public function createInstitutionAdmins()
    {
        /** @var InstitutionName $institutionName */
        foreach (InstitutionName::all() as $institutionName) {
            $univ = strtolower($institutionName->acronym);

            $name = "$institutionName->acronym Super Admin";
            $email = "hemis-super@$univ.edu.et";

            if (User::all()->where('email', $email)->first() == null) {
                $user = $this->makeUser($name, $email);

                $institutionName->users()->save($user);
                $this->instance->users()->save($user);

                $user->roles()->attach(Role::where('role_name', 'University Admin')->first());
                $this->createInstitution($institutionName, $user);
            }
        }
    }

    /**
     * @param $name
     * @param $email
     * @return User
     */
    private function makeUser($name, $email)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make('00000000');
        return $user;
    }

    /**
     * @param InstitutionName $institutionName
     * @param User $user
     */
    private function createInstitution(InstitutionName $institutionName, User $user)
    {
        if ($user->institution() == null) {
            $generalInformation = new GeneralInformation();
            $communityService = new CommunityService();
            $resource = new Resource();

            $generalInformation->save();
            $communityService->save();
            $resource->save();

            $generalInformation->communityService()->associate($communityService)->save();
            $generalInformation->resource()->associate($resource)->save();

            $institution = new Institution();
            $institution->institution_name_id = $institutionName->id;
            $institution->instance_id = $this->instance->id;

            $generalInformation->institution()->save($institution);
        }
    }

    /**
     *
     */
    public function createInstitutionVPs()
    {
        /** @var InstitutionName $institutionName */
        foreach (InstitutionName::all() as $institutionName) {
            $univ = strtolower($institutionName->acronym);

            $name = "$institutionName->acronym Read-Only Admin";
            $email = "hemis-super-vp@$univ.edu.et";

            if (User::all()->where('email', $email)->first() == null) {
                $user = $this->makeUser($name, $email);

                $user->read_only = true;
                $institutionName->users()->save($user);
                $this->instance->users()->save($user);

                $user->roles()->attach(Role::where('role_name', 'University Admin')->first());
            }
        }
    }

    /**
     * @param InstitutionName $institutionName
     */
    public function createCollegeSuperAdmins(InstitutionName $institutionName)
    {
        /** @var CollegeName $collegeName */
        foreach ($institutionName->collegeNames as $collegeName) {
            $univ = strtolower($institutionName->acronym);
            $coll = strtolower($collegeName->acronym);

            $name = "$collegeName->acronym Super Admin";
            $email = "hemis-super-$coll@$univ.edu.et";

            if (User::all()->where('email', $email)->first() == null) {
                $user = $this->makeUser($name, $email);

                $institutionName->users()->save($user);
                $collegeName->users()->save($user);
                $this->instance->users()->save($user);

                $user->roles()->attach(Role::where('role_name', 'College Super Admin')->first());
            }
        }
    }

    /**
     * @param CollegeName $collegeName
     */
    public function createCollegeCommonAdmin(CollegeName $collegeName)
    {
        $institutionName = $collegeName->institutionName;
        $univ = strtolower($institutionName->acronym);
        $coll = strtolower($collegeName->acronym);

        $name = "$collegeName->acronym Common Admin";
        $email = "hemis-comm-$coll@$univ.edu.et";

        if (User::all()->where('email', $email)->first() == null) {
            $user = $this->makeUser($name, $email);

            $institutionName->users()->save($user);
            $collegeName->users()->save($user);
            $this->instance->users()->save($user);

            $user->roles()->attach(Role::where('role_name', 'College Admin')->first());
        }
    }

    /**
     * @param CollegeName $collegeName
     */
    public function createDepartmentAdmins(CollegeName $collegeName)
    {
        $institutionName = $collegeName->institutionName;
        foreach ($collegeName->departmentNames as $departmentName) {
            $univ = strtolower($institutionName->acronym);
            $coll = strtolower($collegeName->acronym);
            $dept = strtolower($departmentName->acronym);

            $name = "$departmentName->acronym Admin";
            $email = "hemis-$dept-$coll@$univ.edu.et";

            if (User::all()->where('email', $email)->first() == null) {
                $user = $this->makeUser($name, $email);

                $institutionName->users()->save($user);
                $collegeName->users()->save($user);
                $departmentName->users()->save($user);
                $this->instance->users()->save($user);

                $user->roles()->attach(Role::where('role_name', 'Department Admin')->first());
            }
        }
    }
}