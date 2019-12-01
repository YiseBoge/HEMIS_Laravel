<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\DegreeEmployment;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DegreeEmploymentsController extends Controller
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

        $employments = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->degreeEmployments as $employment){
                        $employments[] = $employment;
                        $total += $employment->male_students_number + $employment->female_students_number;
                    }
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->degreeEmployments as $employment){
                        $employments[] = $employment;
                        $total += $employment->male_students_number + $employment->female_students_number;
                    }
        }

        $data = array(
            'employments' => $employments,
            'departments' => $collegeDeps,
            'total' => $total,

            'selected_department' => $requestedDepartment,

            'page_name' => 'students.degree_employment.index'
        );
        //return $filteredEnrollments;
        return view("departments.degree_employment.index")->with($data);
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
            'page_name' => 'students.degree_employment.create'
        );
        //return $filteredEnrollments;
        return view("departments.degree_employment.create")->with($data);
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
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

        $employment = new DegreeEmployment;
        $employment->male_students_number = $request->input('male_number');
        $employment->female_students_number = $request->input('female_number');

        $employment->department_id = $department->id;

        if ($employment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $employment->save();

        return redirect("/student/degree-relevant-employment")->with('success', 'Successfully Added Degree Relevant Employment');
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
        return redirect("/student/degree-relevant-employment");
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

        $degreeEmployment = DegreeEmployment::find($id);

        $data = array(
            'id' => $id,
            'male_students_number' => $degreeEmployment->male_students_number,
            'female_students_number' => $degreeEmployment->female_students_number,
            'page_name' => 'students.degree_employment.edit'
        );

        return view("departments.degree_employment.edit")->with($data);
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $degreeEmployment = DegreeEmployment::find($id);

        $degreeEmployment->male_students_number = $request->input("male_number");
        $degreeEmployment->female_students_number = $request->input("female_number");
        $degreeEmployment->approval_status = "Pending";

        $degreeEmployment->save();

        return redirect("/student/degree-relevant-employment")->with('primary', 'Successfully Updated');
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
        $item = DegreeEmployment::find($id);
        $item->delete();
        return redirect('/student/degree-relevant-employment')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $employment = DegreeEmployment::find($id);
            $employment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $employment->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->degreeEmployments);
                        }
                    }
                }
            }
        }
        return redirect("/student/degree-relevant-employment?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
