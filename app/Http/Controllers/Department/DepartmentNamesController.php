<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\CollegeName;
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
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $departments = array();
        foreach ($institutionName->collegeNames as $collegeName) {
            foreach ($collegeName->departmentNames as $department) {
                $departments[] = $department;
            }
        }

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
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $departments = array();
        foreach ($institutionName->collegeNames as $collegeName) {
            foreach ($collegeName->departmentNames as $department) {
                $departments[] = $department;
            }
        }
        $collegeNames = $institutionName->collegeNames;

        $data = [
            'departments' => $departments,
            'college_names' => $collegeNames,

            'has_modal' => 'yes',
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
        $user->authorizeRoles('University Admin');

        $this->validate($request, [
            'department_name' => 'required',
            'department_acronym' => 'required'
        ]);

        $institutionName = $user->institution()->institutionName;

        $collegeNames = $institutionName->collegeNames;
        /** @var CollegeName $collegeName */
        $collegeName = $collegeNames[$request->input('college_name_id')];

        $departmentName = new DepartmentName;
        $departmentName->department_name = $request->input('department_name');
        $departmentName->acronym = $request->input('department_acronym');

        $collegeName->departmentNames()->save($departmentName);

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
        $user->authorizeRoles('University Admin');

        return redirect('/department/department-name');
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
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $departments = array();
        foreach ($institutionName->collegeNames as $collegeName) {
            foreach ($collegeName->departmentNames as $department) {
                $departments[] = $department;
            }
        }
        $collegeNames = $institutionName->collegeNames;

        $department = DepartmentName::find($id);

        $data = [
            'department' => DepartmentName::find($id),
            'id' => $id,
            'departments' => $departments,
            'college_names' => $collegeNames,
            'department_name' => $department->department_name,
            'department_acronym' => $department->acronym,

            'has_modal' => 'yes',
            'page_name' => 'administer.department-name.edit'
        ];
        return view('departments.department_name.list')->with($data);
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
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $department = DepartmentName::find($id);

        $department->department_name = $request->input("department_name");
        $department->acronym = $request->input("department_acronym");

        if ($department->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $department->save();
        return redirect('/department/department-name');
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
