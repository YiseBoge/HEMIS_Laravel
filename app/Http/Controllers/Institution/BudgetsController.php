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

        $data = ['budget_type' => $requestedType, 'budgets' => $budgets, 'page_name' => 'budget.index'];
        return view('institutions.budget.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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

//        To be removed
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
     */
    public function destroy($id)
    {
        //
    }
}
