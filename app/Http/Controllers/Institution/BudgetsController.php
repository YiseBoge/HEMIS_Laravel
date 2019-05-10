<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Budget;
use App\Models\Institution\BudgetDescription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webpatser\Uuid\Uuid;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $requestedType = $request->input('budget_type');
        if ($requestedType == null) {
            $requestedType = 'CAPITAL';
        }
        $budget_type = Budget::getEnum('budget_type')[$requestedType];

        $budgets = Budget::where('budget_type', $budget_type)->get();

        $data = ['budget_type' => $requestedType, 'budgets' => $budgets, 'page_name' => 'institution.budget.index'];
        return view('institutions.budget.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $budget_type = Budget::getEnum('budget_type')['CAPITAL'];
        $budgets = Budget::where('budget_type', $budget_type)->get();
        $data = ['budget_type' => 'CAPITAL', 'budgets' => $budgets, 'page_name' => 'institution.budget.create'];

        return view('institutions.budget.index')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'budget_type' => 'required',
            'budget_description' => 'required',
            'allocated' => 'required',
            'additional' => 'required',
            'utilized' => 'required',
        ]);

        $exampleDescription = BudgetDescription::all()[$request->input('budget_description')];

        $budget = new Budget();
        $budget->budget_type = $request->input('budget_type');
        $budget->allocated_budget = $request->input('allocated');
        $budget->additional_budget = $request->input('additional');
        $budget->utilized_budget = $request->input('utilized');

//        Todo remove this
        $budget->institution_id = Uuid::generate()->string;

        $exampleDescription->save();
        $exampleDescription->budget()->save($budget);


        return redirect('/institution/budget');
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

        $budget = Budget::find($id);
        $budget_type = Budget::getValueKey(Budget::getEnum("budget_type"), $budget->budget_type);
        $budgets = Budget::where('budget_type', $budget_type)->get();

        $budgetDescriptions = [];
        foreach (BudgetDescription::all() as $description) {
            array_push($budgetDescriptions, $description->__toString());
        }
        $budgetDescription = Budget::getValueKey($budgetDescriptions, $budget->budgetDescription);


        $data = array(
            'budget' => $budget,
            'budget_type' => $budget_type,
            'budgets' => $budgets,
            'budget_descriptions' => $budgetDescriptions,
            'budget_description' => $budgetDescription,
            'page_name' => 'institution.budget.edit'
        );

        return view('institutions.budget.index')->with('data', $data);
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
        $this->validate($request, [
            'budget_type' => 'required',
            'budget_description' => 'required',
            'allocated' => 'required',
            'additional' => 'required',
            'utilized' => 'required',
        ]);

        $exampleDescription = BudgetDescription::all()[$request->input('budget_description')];

        $budget = Budget::find($id);
        $budget->allocated_budget = $request->input('allocated');
        $budget->additional_budget = $request->input('additional');
        $budget->utilized_budget = $request->input('utilized');

        $budget->save();

        $exampleDescription->budget()->save($budget);

        return redirect('/institution/budget');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
