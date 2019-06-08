<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Institution\InstitutionName;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UniversityAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $editors = [];
        foreach (User::all() as $user) {
            if ($user->hasRole('University Admin')) {
                array_push($editors, $user);
            }
        }

        $data = array(
            'editors' => $editors,
            'page_name' => 'users.university_admin.index',
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
        $institutionNames = InstitutionName::all();
        $collegeNames = CollegeName::all();
        $bandNames = BandName::all();
        $departmentNames = DepartmentName::all();

        $data = array(
            'institution_names' => $institutionNames,
            'college_names' => $collegeNames,
            'band_names' => $bandNames,
            'department_names' => $departmentNames,
            'page_name' => 'users.university_admin.create',
        );
        return view('users.university_admin.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $currentInstanceId = Auth::user()->currentInstance;
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'institution_name_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $institutionNames = InstitutionName::all();
        $institutionName = $institutionNames[$request->input('institution_name_id')];

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $institutionName->users()->save($user);
        $currentInstanceId->users()->save($user);

        $user
            ->roles()
            ->attach(Role::where('role_name', 'University Admin')->first());

        return redirect('/university-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
