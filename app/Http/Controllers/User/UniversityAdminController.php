<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Institution\CommunityService;
use App\Models\Institution\GeneralInformation;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\Resource;
use App\Role;
use App\Services\UserService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UniversityAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $editors = [];
        foreach (User::all() as $user)
            if ($user->hasRole('University Admin'))
                array_push($editors, $user);

        $data = array(
            'editors' => $editors,
            'page_name' => 'administer.university_admin.index',
        );
        return view('users.university_admin.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $institutionNames = InstitutionName::all();
        $collegeNames = CollegeName::all();
        $departmentNames = DepartmentName::all();

        $data = array(
            'institution_names' => $institutionNames,
            'college_names' => $collegeNames,
            'department_names' => $departmentNames,
            'page_name' => 'administer.university_admin.create',
        );
        return view('users.university_admin.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'institution_name_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $currentInstanceId = $user->currentInstance;

        $institutionNames = InstitutionName::all();
        /** @var InstitutionName $institutionName */
        $institutionName = $institutionNames[$request->input('institution_name_id')];

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->read_only = $request->has('read_only');

        $institutionName->users()->save($user);
        $currentInstanceId->users()->save($user);

        $user
            ->roles()
            ->attach(Role::where('role_name', 'University Admin')->first());

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
            $institution->instance_id = $currentInstanceId->id;

            $generalInformation->institution()->save($institution);
        }
        return redirect('/university-admin')->with('success', 'Successfully Added University Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/university-admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $univ_admin = User::findOrFail($id);

        $data = array(
            'univ_admin' => $univ_admin,
            'page_name' => 'administer.university_admin.create',
        );
        return view('users.university_admin.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $univ_admin = User::findOrFail($id);
        $univ_admin->password = Hash::make($request->input('password'));

        $univ_admin->save();

        return redirect('/university-admin')->with('success', 'Successfully Changed University Admin Password');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->delete();
        return redirect('/university-admin')->with('primary', 'Successfully Deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     * @throws Exception
     */
    public function autoGenerate()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $instance = $user->currentInstance;

        $service = new UserService($instance);
        $service->createInstitutionAdmins();
        $service->createInstitutionVPs();

        return redirect('/university-admin')->with('primary', 'Successfully Generated Admins');
    }
}
