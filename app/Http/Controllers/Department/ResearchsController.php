<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\Research;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResearchsController extends Controller
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
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = $collegeDeps->first()->id;
        }

        $researches = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->researches as $research) {
                                            $researches[] = $research;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->researches as $research) {
                                            if ($research->type == $requestedType) {
                                                $researches[] = $research;
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
            $researches = Research::with('department')->get();
        }

        $data = array(
            'researchs' => $researches,
            'departments' => $collegeDeps,
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'research.research.index',

            'selected_department' => $requestedDepartment,
            "selected_type" => $requestedType
        );
        return view("bands.research.index")->with($data);
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
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'research.research.create'
        );
        return view("bands.research.create")->with($data);
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
            'number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
            'budget' => 'required|numeric|between:0,1000000000',
            'external_budget' => 'required|numeric|between:0,1000000000',
            'male_participating_number' => 'required|numeric|between:0,1000000000',
            'female_participating_number' => 'required|numeric|between:0,1000000000',
            'other_male_number' => 'required|numeric|between:0,1000000000',
            'other_female_number' => 'required|numeric|between:0,1000000000'
        ]);

        $research = new Research;
        $research->number = $request->input('number');
        $research->male_teachers_participating_number = $request->input('male_participating_number');
        $research->female_teachers_participating_number = $request->input('female_participating_number');
        $research->female_researchers_number = $request->input('female_number');
        $research->male_researchers_other_number = $request->input('other_male_number');
        $research->female_researchers_other_number = $request->input('other_female_number');
        $research->budget_allocated = $request->input('budget');
        $research->budget_from_externals = $request->input('external_budget');
        $research->status = $request->input('status');
        $research->type = $request->input('type');

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
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
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

        $research->department_id = $department->id;

        if ($research->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $research->save();

        return redirect("/institution/researches")->with('success', 'Successfully Added Research');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/institution/researches");
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
        $user->authorizeRoles('Department Admin');

        $research = Research::find($id);

        $data = array(
            'id' => $id,
            'research' => $research,
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'research.research.create'
        );
        return view("bands.research.edit")->with($data);
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
            'number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000',
            'budget' => 'required|numeric|between:0,1000000000',
            'external_budget' => 'required|numeric|between:0,1000000000',
            'male_participating_number' => 'required|numeric|between:0,1000000000',
            'female_participating_number' => 'required|numeric|between:0,1000000000',
            'other_male_number' => 'required|numeric|between:0,1000000000',
            'other_female_number' => 'required|numeric|between:0,1000000000'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $research = Research::find($id);

        $research->number = $request->input('number');
        $research->male_teachers_participating_number = $request->input('male_participating_number');
        $research->female_teachers_participating_number = $request->input('female_participating_number');
        $research->female_researchers_number = $request->input('female_number');
        $research->male_researchers_other_number = $request->input('other_male_number');
        $research->female_researchers_other_number = $request->input('other_female_number');
        $research->budget_allocated = $request->input('budget');
        $research->budget_from_externals = $request->input('external_budget');
        $research->approval_status = "Pending";

        $research->save();
        return redirect('/institution/researches')->with('primary', 'Successfully Updated');
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
        $item = Research::find($id);
        $item->delete();
        return redirect('/institution/researches')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $research = Research::find($id);
            $research->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $research->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        ApprovalService::approveData($department->researches);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect("/institution/researches")->with('primary', 'Success');
    }

}
