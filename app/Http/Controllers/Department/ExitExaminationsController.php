<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\ExitExamination;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ExitExaminationsController extends Controller
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

        $examinations = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->exitExaminations as $examination)
                        $examinations[] = $examination;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->exitExaminations as $examination)
                        $examinations[] = $examination;
        }

        $data = array(
            'examinations' => $examinations,
            'departments' => $collegeDeps,

            'selected_department' => $requestedDepartment,

            'page_name' => 'students.exit_examination.index'
        );
        //return $filteredEnrollments;
        return view("departments.exit_examination.index")->with($data);
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
            'page_name' => 'students.exit_examination.create'
        );
        //return $filteredEnrollments;
        return view("departments.exit_examination.create")->with($data);
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
            'males_sat' => 'required|numeric|between:0,1000000000',
            'females_sat' => 'required|numeric|between:0,1000000000',
            'males_passed' => 'required|numeric|between:0,1000000000',
            'females_passed' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'None');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $examination = new ExitExamination;
        $examination->males_sat = $request->input('males_sat');
        $examination->females_sat = $request->input('females_sat');
        $examination->males_passed = $request->input('males_passed');
        $examination->females_passed = $request->input('females_passed');

        $examination->department_id = $department->id;

        if ($examination->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $examination->save();

        return redirect("/student/exit-examination")->with('success', 'Successfully Added Exit Examination Info');
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
        return redirect("/student/exit-examination");
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
        $user->authorizeRoles('Department Admin');

        $exitExamination = ExitExamination::find($id);
        $department = $exitExamination->department()->first();
        $departmentName = $department->departmentName()->first();

        $data = array(
            'id' => $id,
            'departmentName' => $departmentName,
            'exit_examination' => $exitExamination,

            'page_name' => 'departments.exit_examination.edit'
        );

        return view("departments.exit_examination.edit")->with($data);
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
            'males_sat' => 'required|numeric|between:0,1000000000',
            'females_sat' => 'required|numeric|between:0,1000000000',
            'males_passed' => 'required|numeric|between:0,1000000000',
            'females_passed' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $exitExamination = ExitExamination::find($id);

        $exitExamination->males_sat = $request->input('males_sat');
        $exitExamination->females_sat = $request->input('females_sat');
        $exitExamination->males_passed = $request->input('males_passed');
        $exitExamination->females_passed = $request->input('females_passed');
        $exitExamination->approval_status = "Pending";

        $exitExamination->save();

        return redirect("/student/exit-examination")->with('primary', 'Successfully Updated');
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
        $item = ExitExamination::find($id);
        $item->delete();
        return redirect('/student/exit-examination')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $examination = ExitExamination::find($id);
            $examination->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $examination->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->exitExaminations);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/exit-examination?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
