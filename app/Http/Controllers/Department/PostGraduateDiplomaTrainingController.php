<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\PostGraduateDiplomaTraining;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostGraduateDiplomaTrainingController extends Controller
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

        if ($request->input('type') == null) {
            $requestedType = 0;
        } else if ($request->input('type') == "Teachers") {
            $requestedType = 0;
        } else {
            $requestedType = 1;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $trainings = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->id == $user->bandName->id) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->id == $user->collegeName->id) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->postgraduateDiplomaTrainings as $training) {
                                            $trainings[] = $training;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->id == $user->collegeName->id && $college->education_level == "None") {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->postgraduateDiplomaTrainings as $training) {
                                            if ($training->is_lead == $requestedType) {
                                                $trainings[] = $training;
                                            }
                                        }
                                    }
                                }
                            }

                        }

                    }
                }
            }
        } else {
            $trainings = PostGraduateDiplomaTraining::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'trainings' => $trainings,
            'departments' => DepartmentName::all(),
            'programs' => PostGraduateDiplomaTraining::getEnum("Programs"),
            'types' => PostGraduateDiplomaTraining::getEnum('Types'),
            'page_name' => 'staff.postgraduate_diploma_training.index',

            'selected_department' => $requestedDepartment,
            'selected_type' => $requestedType,
            'selected_program' => $requestedProgram

        );
        return view("departments.postgraduate_diploma_training.index")->with($data);
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
            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'departments' => DepartmentName::all(),
            'programs' => PostGraduateDiplomaTraining::getEnum("Programs"),
            'types' => PostGraduateDiplomaTraining::getEnum('Types'),
            'page_name' => 'staff.postgraduate_diploma_training.create'
        );

        return view("departments.postgraduate_diploma_training.create")->with($data);

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

        $training = new PostGraduateDiplomaTraining;
        $training->number_of_male_students = $request->input('male_number');
        $training->number_of_female_students = $request->input('female_number');
        if ($request->input('type') == "TEACHERS") {
            $training->is_lead = 0;
        } else {
            $training->is_lead = 1;
        }

        $user = Auth::user();
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
            'education_level' => "None", 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = $request->input("program");
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

        $training->department_id = $department->id;

        if ($training->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $training->save();

        return redirect("/department/postgraduate-diploma-training")->with('success', 'Successfully Added Diploma Training');
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
        return redirect("/department/postgraduate-diploma-training");
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

        $postGraduateDiplomaTraining = PostGraduateDiplomaTraining::find($id);
        $department = $postGraduateDiplomaTraining->department()->first();
        $college = $department->college()->first();

        $data = array(
            'id' => $id,
            'program' => $college->education_program,
            'teacher_type' => $postGraduateDiplomaTraining->is_lead,
            'male_number' => $postGraduateDiplomaTraining->number_of_male_students,
            'female_number' => $postGraduateDiplomaTraining->number_of_female_students,
            'page_name' => 'staff.postgraduate_diploma_training.edit'
        );

        return view("departments.postgraduate_diploma_training.edit")->with($data);
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

        $postGraduateDiplomaTraining = PostGraduateDiplomaTraining::find($id);

        $postGraduateDiplomaTraining->number_of_male_students = $request->input("male_number");
        $postGraduateDiplomaTraining->number_of_female_students = $request->input("female_number");

        $postGraduateDiplomaTraining->save();

        return redirect("/department/postgraduate-diploma-training")->with('primary', 'Successfully Updated');
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
        $item = PostGraduateDiplomaTraining::find($id);
        $item->delete();
        return redirect('/department/postgraduate-diploma-training')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $training = PostGraduateDiplomaTraining::find($id);
        if ($action == "approve") {
            $training->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $training->save();
        } elseif ($action == "disapprove") {
            $training->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $training->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->postgraduateDiplomaTrainings as $training) {
                                            if ($training->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                                $training->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $training->save();
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
        return redirect("/department/postgraduate-diploma-training")->with('primary', 'Success');
    }
}
