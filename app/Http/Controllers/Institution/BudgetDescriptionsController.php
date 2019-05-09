<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\BudgetDescription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Institution\BudgetDescription;

class BudgetDescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $budgetDescriptions=BudgetDescription::all();
        return view('institutions.budget_description.index')->with('budgetDescriptions',$budgetDescriptions);
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
            'budget_code' => 'required',
            'description' => 'required',
        ]);

        $budgetDescription = new BudgetDescription();
        $budgetDescription->budget_code = $request->input('budget_code');
        $budgetDescription->description = $request->input('description');

        $budgetDescription->save();

        return redirect('/institution/budget-description');
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
