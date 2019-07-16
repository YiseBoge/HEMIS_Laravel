<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\CostSharing;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CostSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $costSharings = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->departments as $department) {
                                if ($user->hasRole('College Super Admin')) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->costSharings as $costSharing) {
                                            $costSharings[] = $costSharing;
                                        }
                                    }
                                } else {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->costSharings as $costSharing) {
                                            $costSharings[] = $costSharing;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $costSharings = CostSharing::with('department')->get();
        }

        $data = array(
            'costSharings' => $costSharings,
            'departments' => DepartmentName::all(),

            'selected_department' => $requestedDepartment,

            'page_name' => 'students.cost_sharing.index'
        );
        return view("departments.cost_sharing.index")->with($data);

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
        $user->authorizeRoles('Department Admin');

        $data = array(
            'page_name' => 'students.cost_sharing.create'
        );

        return view("departments.cost_sharing.create")->with($data);
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
            'name' => 'required',
            'student_id' => 'required',
            'sex' => 'required',
            'field_of_study' => 'required',
            'tin_number' => 'required',
            'receipt_number' => 'required',
            'registration_date' => 'required',
            'clearance_date' => 'required',
            'tuition_fee' => 'required',
            'food_expenses' => 'required',
            'dormitory_expenses' => 'required',
            'pre_payment_amount' => 'required',
            'unpaid_amount' => 'required'
        ]);

        $costSharing = new CostSharing;
        $costSharing->name = $request->input('name');
        $costSharing->student_id = $request->input('student_id');
        $costSharing->sex = $request->input('sex');
        $costSharing->field_of_study = $request->input('field_of_study');
        $costSharing->tin_number = $request->input('tin_number');
        $costSharing->receipt_number = $request->input('receipt_number');
        $costSharing->registration_date = $request->input('registration_date');
        $costSharing->clearance_date = $request->input('clearance_date');
        $costSharing->tuition_fee = $request->input('tuition_fee');
        $costSharing->food_expense = $request->input('food_expenses');
        $costSharing->dormitory_expense = $request->input('dormitory_expenses');
        $costSharing->pre_payment_amount = $request->input('pre_payment_amount');
        $costSharing->unpaid_amount = $request->input('unpaid_amount');

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->costSharings()->save($costSharing);

        return redirect("/student/cost-sharing");
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
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = CostSharing::find($id);
        $item->delete();
        return redirect('/student/cost-sharing');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $costSharing = CostSharing::find($id);
        if ($action == "approve") {
            $costSharing->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $costSharing->save();
        } elseif ($action == "disapprove") {
            $costSharing->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $costSharing->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->costSharings as $costSharing) {
                                            if($costSharing->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]){
                                                $costSharing->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $costSharing->save();
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/cost-sharing?department=" . $selectedDepartment);
    }

}
