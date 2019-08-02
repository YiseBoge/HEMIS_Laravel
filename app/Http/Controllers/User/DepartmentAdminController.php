<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department\DepartmentName;
use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DepartmentAdminController extends Controller
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
        $user->authorizeRoles('College Super Admin');

        $collegeNameId = $user->college_name_id;

        $editors = [];
        foreach (User::all() as $user) {
            if ($user->hasRole('Department Admin') && $user->college_name_id == $collegeNameId) {
                array_push($editors, $user);
            }
        }

        $data = array(
            'editors' => $editors,
            'page_name' => 'administer.department_admin.index',
        );
        return view('users.department_admin.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Super Admin');

        $departmentNames = $user->collegeName->departmentNames;

        $data = array(
            'department_names' => $departmentNames,
            'page_name' => 'administer.department_admin.create',
        );
        return view('users.department_admin.create')->with($data);
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
            'department_name_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Super Admin');

        $currentInstanceId = $user->currentInstance;
        $institutionName = $user->institutionName;
        $collegeName = $user->collegeName;

        $bandName = $user->bandName;

        $departmentNames = DepartmentName::all();
        /** @var DepartmentName $departmentName */
        $departmentName = $departmentNames[$request->input('department_name_id')];

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $institutionName->users()->save($user);
        $collegeName->users()->save($user);
        $bandName->users()->save($user);
        $departmentName->users()->save($user);
        $currentInstanceId->users()->save($user);

        $user
            ->roles()
            ->attach(Role::where('role_name', 'Department Admin')->first());

        return redirect('/department-admin')->with('success', 'Successfully Added Department Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/department-admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return redirect('/department-admin');
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
        return redirect('/department-admin');
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
        $item = User::find($id);
        $item->delete();
        return redirect('/department-admin')->with('primary', 'Successfully Deleted');
    }
}
