<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\College\CollegeName;
use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CollegeAdminController extends Controller
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
        $user->authorizeRoles(['University Admin', 'College Super Admin']);

        $institutionNameId = $user->institution_name_id;

        $editors = [];
        foreach (User::all() as $editor) {
            if ($user->hasRole('University Admin')) {
                if ($editor->hasRole('College Super Admin') && $editor->institution_name_id == $institutionNameId) {
                    array_push($editors, $editor);
                }
            } else {
                if ($editor->hasRole('College Admin') && $editor->institution_name_id == $institutionNameId &&
                    $editor->college_name_id == $user->college_name_id) {
                    array_push($editors, $editor);
                }
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
        $user->authorizeRoles(['University Admin', 'College Super Admin']);

        $collegeNames = $user->institution()->institutionName->collegeNames;

        $currentCollege = null;
        if ($user->hasRole('College Super Admin')) {
            $currentCollege = $collegeNames->search(function ($collegeName) {
                return $collegeName->id === Auth::user()->collegeName->id;
            });
        }

        $data = array(
            'college_names' => $collegeNames,
            'college_name' => $currentCollege,
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
        $user->authorizeRoles(['University Admin', 'College Super Admin']);

        $currentInstanceId = $user->currentInstance;
        $institutionName = $user->institution()->institutionName;

        $collegeNames = CollegeName::all();
        /** @var CollegeName $collegeName */
        $collegeName = $collegeNames[$request->input('college_name_id')];

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $institutionName->users()->save($user);
        $collegeName->bandName->users()->save($user);
        $collegeName->users()->save($user);
        $currentInstanceId->users()->save($user);

        $user
            ->roles()
            ->attach(Role::where('role_name', $request->input('role'))->first());

        return redirect('/college-admin')->with('success', 'Successfully Added College Admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/college-admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return redirect('/college-admin');
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
        return redirect('/college-admin');
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
        return redirect('/college-admin')->with('primary', 'Successfully Deleted');
    }
}
