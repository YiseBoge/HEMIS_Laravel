<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\QualifiedInternship;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class QualifiedInternshipsController extends Controller
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $institution = $user->institution();

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $internships = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->qualifiedInternships as $internship) {
                                            $internships[] = $internship;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == 'None' && $college->education_program == 'None') {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->qualifiedInternships as $internship) {
                                            $internships[] = $internship;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $internships = QualifiedInternship::with('department')->get();
        }

        $data = array(
            'internships' => $internships,
            'departments' => DepartmentName::all(),

            'selected_department' => $requestedDepartment,

            'page_name' => 'student.qualified_internship.index'
        );

        return view("departments.qualified_internship.index")->with($data);
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
            'types' => QualifiedInternship::getEnum('SponsorTypes'),
            'page_name' => 'student.qualified_internship.create'
        );
        //return $filteredEnrollments;
        return view("departments.qualified_internship.create")->with($data);
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
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $internship = new QualifiedInternship;
        $internship->sponsor_type = $request->input('type');
        $internship->male_number = $request->input('male_number');
        $internship->female_number = $request->input('female_number');

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

        $internship->department_id = $department->id;

        if ($internship->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $internship->save();

        return redirect("/student/qualified-internship")->with('success', 'Successfully Added Diaspora Course');

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
        return redirect("/student/qualified-internship");
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

        $internship = QualifiedInternship::find($id);

        $data = array(
            'id' => $id,
            'male_number' => $internship->male_number,
            'female_number' => $internship->female_number,
            'type' => $internship->sponsor_type,
            'page_name' => 'student.qualified_internship.edit'
        );
        return view("departments.qualified_internship.edit")->with($data);
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $internship = QualifiedInternship::find($id);

        $internship->male_number = $request->input('male_number');
        $internship->female_number = $request->input('female_number');

        $internship->save();

        return redirect("/student/qualified-internship")->with('primary', 'Successfully Updated');
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
        $item = QualifiedInternship::find($id);
        $item->delete();
        return redirect('/student/qualified-internship')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $internship = QualifiedInternship::find($id);
            $internship->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $internship->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->qualifiedInternships as $internship) {
                                            if ($internship->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                                $internship->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $internship->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect("/student/qualified-internship")->with('primary', 'Success');
    }

}
