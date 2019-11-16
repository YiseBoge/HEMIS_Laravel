<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\DegreeEmployment;
use App\Models\Department\Department;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
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
        $institution = $user->institution();
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $employments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->degreeEmployments as $employment) {
                                            $employments[] = $employment;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == 'None' && $college->education_program == 'None') {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->degreeEmployments as $employment) {
                                            $employments[] = $employment;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $employments = DegreeEmployment::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'employments' => $employments,
            'departments' => $collegeDeps,

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

        $employment = new DegreeEmployment;
        $employment->male_students_number = $request->input('male_number');
        $employment->female_students_number = $request->input('female_number');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = null;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = 'None';
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => 'None',
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'None';
            $department->department_name_id = null;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

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

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->degreeEmployments);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/degree-relevant-employment?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
