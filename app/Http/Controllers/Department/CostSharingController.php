<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\CostSharing;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CostSharingController extends Controller
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $costSharing = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->costSharings as $cost)
                        $costSharing[] = $cost;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->costSharings as $cost)
                        $costSharing[] = $cost;
        }

        $data = array(
            'costSharings' => $costSharing,
            'departments' => $collegeDeps,

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
            'registration_date' => 'required|date',
            'clearance_date' => 'required|date|after:registration_date',
            'tuition_fee' => 'required|numeric|between:0,10000000',
            'food_expenses' => 'required|numeric|between:0,10000000',
            'dormitory_expenses' => 'required|numeric|between:0,10000000',
            'pre_payment_amount' => 'required|numeric|between:0,10000000',
            'unpaid_amount' => 'required|numeric|between:0,10000000'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'NONE');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

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

        $costSharing->department_id = $department->id;

        if ($costSharing->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $costSharing->save();

        return redirect("/student/cost-sharing")->with('success', 'Successfully Added Cost Sharing Info');
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        return redirect("/student/cost-sharing");
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $costSharings = CostSharing::find($id);
        // die($costSharings);
        $data = array(
            'id' => $id,
            'costSharings' => $costSharings,
            'page_name' => 'students.cost_sharing.edit'
        );
        return view("departments.cost_sharing.edit")->with($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tuition_fee' => 'required|numeric|between:0,10000000',
            'food_expenses' => 'required|numeric|between:0,10000000',
            'dormitory_expenses' => 'required|numeric|between:0,10000000',
            'pre_payment_amount' => 'required|numeric|between:0,10000000',
            'unpaid_amount' => 'required|numeric|between:0,10000000'
        ]);

        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $costSharings = CostSharing::find($id);

        $costSharings->tuition_fee = $request->input("tuition_fee");
        $costSharings->food_expense = $request->input("food_expense");
        $costSharings->dormitory_expense = $request->input("dormitory_expense");
        $costSharings->pre_payment_amount = $request->input("pre_payment_amount");
        $costSharings->unpaid_amount = $request->input("unpaid_amount");
        $costSharing->approval_status = "Pending";

        $costSharings->save();        
        return redirect('/student/cost-sharing')->with('primary', 'Successfully Updated');
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
        return redirect('/student/cost-sharing')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $costSharing = CostSharing::find($id);
            $costSharing->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $costSharing->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->costSharings);
                        }
                    }
                }
            }
        }
        return redirect("/student/cost-sharing?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
