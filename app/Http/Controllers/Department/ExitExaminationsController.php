<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\ExitExamination;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ExitExaminationsController extends Controller
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

        $examinations = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->exitExaminations as $examination) {
                                            $examinations[] = $examination;
                                        }
                                    }
                                }
                            }
                        }else{
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == 'None' && $college->education_program == 'None') {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->exitExaminations as $examination) {
                                            $examinations[] = $examination;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $examinations = ExitExamination::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'examinations' => $examinations,
            'departments' => DepartmentName::all(),

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
        if ($user == null) return redirect('/login');
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
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $examination = new ExitExamination;
        $examination->male_students_number = $request->input('male_number');
        $examination->female_students_number = $request->input('female_number');

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
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = 'None';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => 'None',
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'None';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->exitExaminations()->save($examination);

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
        $item = ExitExamination::find($id);
        $item->delete();
        return redirect('/student/exit-examination');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $examination = ExitExamination::find($id);
        if ($action == "approve") {
            $examination->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $examination->save();
        } elseif ($action == "disapprove") {
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
                                        foreach ($department->exitExaminations as $examination) {
                                            if($examination->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]){
                                                $examination->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $examination->save();
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
        return redirect("/student/exit-examination?department=" . $selectedDepartment)->with('primary', 'Success');
    }

}
