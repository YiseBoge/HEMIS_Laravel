<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Department\DepartmentName;
use App\Models\Institution\ForeignStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ForeignStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $staffs = array();

        if ($institution != null) {
            foreach ($institution->foreignStaff as $staff) {
                $staffs[] = $staff;
            }
        } else {
            $staffs = ForeignStaff::all();
        }

        $data = [
            'staffs' => $staffs,
            'page_name' => 'institution.foreign_staff.list'
        ];
        return view('institutions.foreign_staff.list')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $department_names = DepartmentName::all();

        $data = ['staffs' => ForeignStaff::all(),
            'education_levels' => ForeignStaff::getEnum("EducationLevels"),
            'department' => $department_names,
            'page_name' => 'institution.foreign_staff.create'];
        return view('institutions.foreign_staff.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // die('reached here');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $foreign_staff = new ForeignStaff();
        $foreign_staff->name = $request->input('full_name');
        $foreign_staff->sex = $request->input('sex');
        $foreign_staff->country_of_origin = $request->input('origin');
        $foreign_staff->department = $user->departmentName->department_name;
        $foreign_staff->education_level = $request->input('education_level');
        $foreign_staff->specialization = $request->input('specialization');
        $foreign_staff->employment_date = $request->input('date_of_employment');
        $foreign_staff->contract_start_date = $request->input('start_of_contract');
        $foreign_staff->contract_end_date = $request->input('end_of_contract');
        $foreign_staff->remark = $request->input('additional_remark');

        $foreign_staff->institution_id = $institution->id;

        $foreign_staff->save();

        return redirect('institution/foreign-staff');
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
