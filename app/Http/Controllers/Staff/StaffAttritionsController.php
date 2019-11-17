<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffAttrition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StaffAttritionsController extends Controller
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
        $user->authorizeRoles(['College Admin', 'Department Admin']);

        $requestedCase = request()->query('case', 'Government Appointment');
        $requestedType = request()->query('type', 'Management Staff');

        $attrition = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('Department Admin')) {
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->academicStaffs as $staff)
                        if ($staff->general->staffAttrition != null)
                            $attrition[] = $staff->general->staffAttrition;

            } else {
                $staffs = array();

                switch ($requestedType) {
                    case 'Management Staff':
                        $staffs = $college->managementStaffs;
                        break;
                    case 'Technical Staff':
                        $staffs = $college->technicalStaffs;
                        break;
                    case 'Administrative Staff':
                        $staffs = $college->administrativeStaffs;
                        break;
                    case 'ICT Staff':
                        $staffs = $college->ictStaffs;
                        break;
                    case 'Supportive Staff':
                        $staffs = $college->supportiveStaffs;
                        break;
                }

                foreach ($staffs as $staff)
                    if ($staff->general->staffAttrition != null)
                        $attrition[] = $staff->general->staffAttrition;
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'attritions' => $attrition,
            'cases' => StaffAttrition::getEnum("Cases"),
            'staff_types' => $staffTypes,

            'selected_type' => $requestedType,
            'selected_case' => $requestedCase,
            'page_name' => 'staff.attrition.index',
        );
        return view('staff.attrition.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'Department Admin']);

        $requestedCase = request()->query('case', 'Government Appointment');
        $requestedType = request()->query('type', 'Management Staff');

        $attrition = array();
        $staffs = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {

            if ($user->hasRole('Department Admin')) {
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->academicStaffs as $staff)
                        if ($staff->general->staffAttrition != null)
                            $attrition[] = $staff->general->staffAttrition;
                        else $staffs[] = $staff;

            } else {
                $currentStaffs = array();
                switch ($requestedType) {
                    case 'Management Staff':
                        $currentStaffs = $college->managementStaffs;
                        break;
                    case 'Technical Staff':
                        $currentStaffs = $college->technicalStaffs;
                        break;
                    case 'Administrative Staff':
                        $currentStaffs = $college->administrativeStaffs;
                        break;
                    case 'ICT Staff':
                        $currentStaffs = $college->ictStaffs;
                        break;
                    case 'Supportive Staff':
                        $currentStaffs = $college->supportiveStaffs;
                        break;
                }

                foreach ($staffs as $staff)
                    if ($staff->general->staffAttrition != null)
                        $attrition[] = $staff->general->staffAttrition;
                    else $staffs[] = $staff;
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'staffs' => $staffs,
            'attritions' => $attrition,
            'cases' => StaffAttrition::getEnum("Cases"),
            'staff_types' => $staffTypes,

            'selected_type' => $requestedType,
            'selected_case' => $requestedCase,
            'page_name' => 'staff.attrition.create'
        );
        return view('staff.attrition.index')->with($data);
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
            'case' => 'required',
            'staff' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'Department Admin']);

        $attrition = new StaffAttrition;
        $attrition->case = $request->input('case');

        $staff = Staff::find($request->input('staff'));
        $staff->staffAttrition()->save($attrition);

        return redirect('/staff/attrition')->with('success', 'Successfully Added Staff Attrition');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/staff/attrition');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return redirect('/staff/attrition');
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
        return redirect('/staff/attrition');
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
        $item = StaffAttrition::find($id);
        $item->delete();
        return redirect('/staff/attrition')->with('primary', 'Successfully Deleted');
    }
}
