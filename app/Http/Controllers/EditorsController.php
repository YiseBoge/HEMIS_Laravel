<?php

namespace App\Http\Controllers;

use App\Models\Institution\InstitutionName;
use App\Models\College\CollegeName;
use App\Models\Band\BandName;
use App\Models\Department\DepartmentName;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditorsController extends Controller
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
            if ($user->hasRole('Admin')) {
                array_push($editors, $user);
            }
        }

        $data = array(
            'editors' => $editors,
            'page_name' => 'auth.editors.index',
        );
        return view('auth.editors.index')->with($data);
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
            'page_name' => 'auth.editors.create',
        );
        return view('auth.editors.create')->with('data', $data);
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
            'band_name_id' => ['required'],
            'college_name_id' => ['required'],
            'department_name_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $institutionNames = InstitutionName::all();
        $institutionName = $institutionNames[$request->input('institution_name_id')];

        $bandNames = BandName::all();
        $bandName = $bandNames[$request->input('band_name_id')];

        $collegeNames = CollegeName::all();
        $collegeName = $collegeNames[$request->input('college_name_id')];

        $departmentNames = DepartmentName::all();
        $departmentName = $departmentNames[$request->input('department_name_id')];


        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $institutionName->users()->save($user);
        $bandName->users()->save($user);
        $collegeName->users()->save($user);
        $departmentName->users()->save($user);
        $currentInstanceId->users()->save($user);

        $user
            ->roles()
            ->attach(Role::where('role_name', 'Admin')->first());

        return redirect('/editors');
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
