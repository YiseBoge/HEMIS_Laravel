<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\Budget;
use App\Models\College\BudgetDescription;
use App\Models\College\College;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BudgetsController extends Controller
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
        $user->authorizeRoles(['College Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budget_type = Budget::getEnum('budget_type')[$requestedType = request()->query('budget_type', 'CAPITAL')];

        $budgets = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                if ($user->hasRole('College Super Admin'))
                    foreach ($college->budgets as $budget)
                        $budgets[] = $budget;
                else
                    foreach ($college->budgets()->where('budget_type', $budget_type)->get() as $budget)
                        $budgets[] = $budget;

        $data = [
            'budget_type' => $requestedType,
            'budget_types' => Budget::getEnum('budget_type'),
            'budgets' => $budgets,
            'page_name' => 'budgets.budget.index'
        ];
        return view('budgets.budget.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $budget_type = Budget::getEnum('budget_type')['CAPITAL'];

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budgets = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                if ($user->hasRole('College Super Admin'))
                    foreach ($college->budgets as $budget)
                        $budgets[] = $budget;
                else
                    foreach ($college->budgets()->where('budget_type', $budget_type) as $budget)
                        $budgets[] = $budget;

        $data = [
            'budget_type' => 'CAPITAL',
            'budget_types' => Budget::getEnum('budget_type'),
            'budget_descriptions' => BudgetDescription::all(),
            'budgets' => $budgets,

            'has_modal' => 'yes',
            'page_name' => 'budgets.budget.create'
        ];

        return view('budgets.budget.index')->with($data);
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
            'budget_type' => 'required',
            'budget_description' => 'required',
            'allocated' => 'required|numeric|between:1,10000000',
            'additional' => 'required|numeric|between:1,10000000',
            'utilized' => 'required|numeric|between:1,10000000',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');
        $exampleDescription = BudgetDescription::all()[$request->input('budget_description')];

        $budget = new Budget();
        $budget->budget_type = $request->input('budget_type');
        $budget->allocated_budget = $request->input('allocated');
        $budget->additional_budget = $request->input('additional');
        $budget->utilized_budget = $request->input('utilized');

        $budget->college_id = $college->id;
        $budget->budget_description_id = $exampleDescription->id;

        if ($budget->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $budget->save();

        return redirect('/budgets/budget')->with('success', 'Successfully Added Budget');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/budgets/budget');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $budget = Budget::find($id);
        $budget_type = Budget::getValueKey(Budget::getEnum("budget_type"), $budget->budget_type);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budgets = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                if ($user->hasRole('College Super Admin'))
                    foreach ($college->budgets as $budget)
                        $budgets[] = $budget;
                else
                    foreach ($college->budgets()->where('budget_type', $budget_type) as $budget)
                        $budgets[] = $budget;

        $budgetDescriptions = [];
        foreach (BudgetDescription::all() as $description) {
            array_push($budgetDescriptions, $description->__toString());
        }
        $budgetDescription = Budget::getValueKey($budgetDescriptions, $budget->budgetDescription);

        $data = array(
            'selected_budget' => $budget,
            'budget_type' => $budget_type,
            'budget_types' => Budget::getEnum('budget_type'),
            'budgets' => $budgets,
            'budget_descriptions' => $budgetDescriptions,
            'budget_description' => $budgetDescription,

            'has_modal' => 'yes',
            'page_name' => 'budgets.budget.edit'
        );

        return view('budgets.budget.index')->with($data);
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
            'allocated' => 'required|numeric|between:1,10000000',
            'additional' => 'required|numeric|between:1,10000000',
            'utilized' => 'required|numeric|between:1,10000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $exampleDescription = BudgetDescription::all()[$request->input('budget_description')];

        $budget = Budget::find($id);
        $budget->allocated_budget = $request->input('allocated');
        $budget->additional_budget = $request->input('additional');
        $budget->utilized_budget = $request->input('utilized');
        $budget->approval_status = "Pending";

        $budget->save();

        $exampleDescription->budget()->save($budget);

        return redirect('/budgets/budget')->with('primary', 'Successfully Updated');
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
        $item = Budget::find($id);
        $item->delete();
        return redirect('/budgets/budget')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');


        if ($action == "disapprove") {
            $budget = Budget::find($id);
            $budget->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $budget->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    ApprovalService::approveData($college->budgets);
                }
            }
        }
        return redirect("/budgets/budget")->with('primary', 'Success');
    }
}
