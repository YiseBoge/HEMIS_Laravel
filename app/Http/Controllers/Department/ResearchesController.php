<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Research;
use App\Models\College\College;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResearchesController extends Controller
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

        $requestedType = request()->query('type', 'Normal');
        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $researches = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->researches as $research)
                        $researches[] = $research;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->researches()->where('type', $requestedType) as $research)
                        $researches[] = $research;
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

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'NONE');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

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

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->researches);
                        }
                    }
                }
            }
        }
        return redirect("/institution/researches")->with('primary', 'Success');
    }

}
