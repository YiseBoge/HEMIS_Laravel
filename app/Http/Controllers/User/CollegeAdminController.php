<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CollegeAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $editors = [];
        foreach (User::all() as $user) {
            if ($user->hasAnyRole(['College Admin', 'College Super Admin'])) {
                array_push($editors, $user);
            }
        }

        $data = array(
            'editors' => $editors,
            'page_name' => 'administer.college_admin.index',
        );
        return view('users.college_admin.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $collegeNames = CollegeName::all();
        $bandNames = BandName::all();

        $data = array(
            'college_names' => $collegeNames,
            'band_names' => $bandNames,
            'page_name' => 'administer.college_admin.create',
        );
        return view('users.college_admin.create')->with($data);

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
            'college_name_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $currentInstanceId = $user->currentInstance;
        $institutionName = $user->institution()->institutionName;

        $bandNames = BandName::all();
        $bandName = $bandNames[$request->input('band_name_id')];

        $collegeNames = CollegeName::all();
        $collegeName = $collegeNames[$request->input('college_name_id')];

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $institutionName->users()->save($user);
        $bandName->users()->save($user);
        $collegeName->users()->save($user);
        $currentInstanceId->users()->save($user);

        if ($request->has('is_super_admin')) {
            $user
                ->roles()
                ->attach(Role::where('role_name', 'College Super Admin')->first());
        } else {
            $user
                ->roles()
                ->attach(Role::where('role_name', 'College Admin')->first());
        }
        

        return redirect('/college-admin');
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
