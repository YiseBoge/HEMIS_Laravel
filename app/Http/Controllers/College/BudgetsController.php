<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\Budget;
use App\Models\College\BudgetDescription;
use App\Models\College\College;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $requestedType = $request->input('budget_type');
        if ($requestedType == null) {
            $requestedType = 'CAPITAL';
        }
        $budget_type = Budget::getEnum('budget_type')[$requestedType];


        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budgets = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->budgets as $budget) {
                            if ($budget->budget_type == $budget_type) {
                                $budgets[] = $budget;
                            }
                        }
                    }
                }
            }
        } else {
            $budgets = Budget::where('budget_type', $budget_type)->get();
        }


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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budgets = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->budgets as $budget) {
                            if ($budget->budget_type == $budget_type) {
                                $budgets[] = $budget;
                            }
                        }
                    }
                }
            }
        } else {
            $budgets = Budget::where('budget_type', $budget_type)->get();
        }

        $data = [
            'budget_type' => 'CAPITAL',
            'budget_types' => Budget::getEnum('budget_type'),
            'budget_descriptions' => BudgetDescription::all(),
            'budgets' => $budgets,
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

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
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
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->budgets()->save($budget);
        $budget = Budget::find($budget->id);
        $exampleDescription->budget()->save($budget);

        return redirect('/budgets/budget');
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

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $budgets = array();
        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->budgets as $budget) {
                            if ($budget->budget_type == $budget_type) {
                                $budgets[] = $budget;
                            }
                        }
                    }
                }
            }
        } else {
            $budgets = Budget::where('budget_type', $budget_type)->get();
        }

        $budgetDescriptions = [];
        foreach (BudgetDescription::all() as $description) {
            array_push($budgetDescriptions, $description->__toString());
        }
        $budgetDescription = Budget::getValueKey($budgetDescriptions, $budget->budgetDescription);


        $data = array(
            'budget' => $budget,
            'budget_type' => $budget_type,
            'budget_types' => Budget::getEnum('budget_type'),
            'budgets' => $budgets,
            'budget_descriptions' => $budgetDescriptions,
            'budget_description' => $budgetDescription,
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
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');

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

        return redirect('/budgets/budget');
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
