<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\BudgetDescription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BudgetDescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $budgetDescriptions = BudgetDescription::all();

        $data = array(
            'budgetDescriptions' => $budgetDescriptions,
            'page_name' => 'administer.budget-description.index',
        );
        return view('colleges.budget_description.index')->with($data);
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
        $user->authorizeRoles('Super Admin');

        $budgetDescriptions = BudgetDescription::all();

        $data = array(
            'budgetDescriptions' => $budgetDescriptions,
            'page_name' => 'administer.budget-description.create',
        );
        return view('colleges.budget_description.index')->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'budget_code' => 'required',
            'description' => 'required',
        ]);

        $budgetDescription = new BudgetDescription();
        $budgetDescription->budget_code = $request->input('budget_code');
        $budgetDescription->description = $request->input('description');

        $budgetDescription->save();

        return redirect('/budgets/budget-description');
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
        $item = BudgetDescription::find($id);
        $item->delete();
        return redirect('/budgets/budget-description');
    }
}
