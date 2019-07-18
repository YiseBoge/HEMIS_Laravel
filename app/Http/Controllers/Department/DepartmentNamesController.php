<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department\DepartmentName;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * A class for the Admin to manage all allowable Department Names
 */
class DepartmentNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $departments = $institutionName->departmentNames;

        $data = [
            'departments' => $departments,
            'page_name' => 'administer.department-name.list'
        ];
        return view('departments.department_name.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $departments = $institutionName->departmentNames;

        $data = [
            'departments' => $departments,
            'page_name' => 'administer.department-name.create'
        ];
        return view('departments.department_name.list')->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $this->validate($request, [
            'department_name' => 'required',
            'department_acronym' => 'required'
        ]);

        $institutionName = $user->institution()->institutionName;

        $departmentName = new DepartmentName;
        $departmentName->department_name = $request->input('department_name');
        $departmentName->acronym = $request->input('department_acronym');

        $institutionName->departmentNames()->save($departmentName);

        return redirect('/department/department-name')->with('success', 'Successfully Added Department Name');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        return view('departments.details');
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $department = DepartmentName::find($id);
        return view('departments.list')->with('departmentEdit', $department);
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
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = DepartmentName::find($id);
        $item->delete();
        return redirect('/department/department-name');
    }
}
