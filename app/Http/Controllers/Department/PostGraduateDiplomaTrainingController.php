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
use App\Services\ApprovalService;
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
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedProgram = request()->query('program', 'Regular');
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);
        $requestedType = request()->query('type', 'Teachers') == "Teachers" ? 0 : 1;

        $trainings = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->postgraduateDiplomaTrainings as $training)
                        $trainings[] = $training;
            } else
                if ($college->education_program == $requestedProgram)
                    foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                        foreach ($department->postgraduateDiplomaTrainings()->where('is_lead', $requestedType)->get() as $training)
                            $trainings[] = $training;
        }

        $data = array(
            'trainings' => $trainings,
            'departments' => $collegeDeps,
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
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
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
            $band->band_name_id = null;
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
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = null;
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

        $postGraduateDiplomaTraining = PostGraduateDiplomaTraining::find($id);

        $postGraduateDiplomaTraining->number_of_male_students = $request->input("male_number");
        $postGraduateDiplomaTraining->number_of_female_students = $request->input("female_number");
        $postGraduateDiplomaTraining->approval_status = "Pending";

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

        if ($action == "disapprove") {
            $training = PostGraduateDiplomaTraining::find($id);
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
                                        ApprovalService::approveData($department->postgraduateDiplomaTrainings);
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
