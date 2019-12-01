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
        $user->authorizeRoles('Super Admin');

        $budgetDescriptions = BudgetDescription::all();

        $data = array(
            'budgetDescriptions' => $budgetDescriptions,

            'has_modal' => 'yes',
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
        $this->validate($request, [
            'budget_code' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $budgetDescription = new BudgetDescription();
        $budgetDescription->budget_code = $request->input('budget_code');
        $budgetDescription->description = $request->input('description');

        if ($budgetDescription->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $budgetDescription->save();

        return redirect('/budgets/budget-description')->with('success', 'Successfully Added Budget Description');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/budgets/budget-description');
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
        $user->authorizeRoles('Super Admin');

        $budgetDescriptions = BudgetDescription::all();
        $current_desc = BudgetDescription::find($id);
        $data = array(
            'id' => $id,
            'budget_code' => $current_desc->budget_code,
            'description' => $current_desc->description,
            'budgetDescriptions' => $budgetDescriptions,

            'has_modal' => 'yes',
            'page_name' => 'administer.budget-description.edit',
        );
        return view('colleges.budget_description.index')->with($data);
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
            'budget_code' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $current_desc = BudgetDescription::find($id);

        $current_desc->budget_code = $request->input("budget_code");
        $current_desc->description = $request->input("description");

        if ($current_desc->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $current_desc->save();
        return redirect('/budgets/budget-description');
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
