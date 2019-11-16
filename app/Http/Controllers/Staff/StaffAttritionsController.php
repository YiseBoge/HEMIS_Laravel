<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
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
        $institution = $user->institution();

        $requestedCase = request()->query('case', 'Government Appointment');
        $requestedType = request()->query('type', 'Management Staff');

        $attritions = array();

        if ($user->hasRole('Department Admin')) {
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->academicStaffs as $staff) {
                                            $attrition = $staff->general->staffAttrition;
                                            if ($attrition != null) {
                                                //return "sgsdfa";
                                                $attritions[] = $attrition;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            } else {
                $attritions = StaffAttrition::all();
            }
        } else {
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                $staffs = array();

                                if ($requestedType == 'Management Staff') {
                                    $staffs = $college->managementStaffs;
                                } else if ($requestedType == 'Technical Staff') {
                                    $staffs = $college->technicalStaffs;
                                } else if ($requestedType == 'Administrative Staff') {
                                    $staffs = $college->administrativeStaffs;
                                } else if ($requestedType == 'ICT Staff') {
                                    $staffs = $college->ictStaffs;
                                } else if ($requestedType == 'Supportive Staff') {
                                    $staffs = $college->supportiveStaffs;
                                }

                                foreach ($staffs as $staff) {
                                    $attrition = $staff->general->staffAttrition;
                                    if ($attrition != null) {
                                        $attritions[] = $attrition;
                                    }
                                }
                            }
                        }
                    }

                }
            } else {
                $attritions = StaffAttrition::all();
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'attritions' => $attritions,
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
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'Department Admin']);
        $institution = $user->institution();

        $requestedCase = $request->input('case');
        if ($requestedCase == null) {
            $requestedCase = 'Government Appointment';
        }

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'Management Staff';
        }

        $attritions = array();
        $staffs = array();

        if ($user->hasRole('Department Admin')) {
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->academicStaffs as $staff) {
                                            $attrition = $staff->general->staffAttrition;
                                            if ($attrition != null) {
                                                $attritions[] = $attrition;
                                            } else {
                                                $staffs[] = $staff;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            } else {
                $attritions = StaffAttrition::all();
            }
        } else {
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                $currentStaffs = array();
                                if ($requestedType == 'Management Staff') {
                                    $currentStaffs = $college->managementStaffs;
                                } else if ($requestedType == 'Technical Staff') {
                                    $currentStaffs = $college->technicalStaffs;
                                } else if ($requestedType == 'Administrative Staff') {
                                    $currentStaffs = $college->administrativeStaffs;
                                } else if ($requestedType == 'ICT Staff') {
                                    $currentStaffs = $college->ictStaffs;
                                } else if ($requestedType == 'Supportive Staff') {
                                    $currentStaffs = $college->supportiveStaffs;
                                }

                                foreach ($currentStaffs as $staff) {

                                    $attrition = $staff->general->staffAttrition;
                                    if ($attrition != null) {

                                        $attritions[] = $attrition;
                                    } else {
                                        //return $staff;
                                        $staffs[] = $staff;
                                    }
                                }
                            }
                        }
                    }

                }
            } else {
                $attritions = StaffAttrition::all();
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'staffs' => $staffs,
            'attritions' => $attritions,
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

        //return $request->input('staff');
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
