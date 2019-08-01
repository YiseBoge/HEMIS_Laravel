<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\Investment;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InvestmentsController extends Controller
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

        $investments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->investments as $investment) {
                            $investments[] = $investment;
                        }
                    }
                }
            }
        } else {
            $investments = Investment::all();
        }

        $data = array(
            'investments' => $investments,
            'page_name' => 'budgets.investment.index'
        );

        return view('budgets.private_investment.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $investmentTitles = Investment::getEnum('investment_title');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $investments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->investments as $investment) {
                            $investments[] = $investment;
                        }
                    }
                }
            }
        } else {
            $investments = Investment::all();
        }

        $data = array(
            'investments' => $investments,
            'investment_titles' => $investmentTitles,

            'has_modal' => 'yes',
            'page_name' => 'budgets.investment.create'
        );

        return view('budgets.private_investment.index')->with($data);
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
            'investment_title' => 'required',
            'cost_incurred' => 'required',
        ]);


        $investment = new Investment();
        $investment->investment_title = $request->input('investment_title');
        $investment->cost_incurred = $request->input('cost_incurred');
        $investment->remarks = $request->input('remarks');

        $user = Auth::user();
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

        $investment->college_id = $college->id;

        if ($investment->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $investment->save();


        return redirect('/budgets/private-investment')->with('success', 'Successfully Added Investment');
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
        $investment = Investment::find($id);

        $investmentTitles = Investment::getEnum('investment_title');
        $investmentTitle = Investment::getValueKey($investmentTitles, $investment->investment_title);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $investments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->investments as $investment) {
                            $investments[] = $investment;
                        }
                    }
                }
            }
        } else {
            $investments = Investment::all();
        }

        $data = array(
            'investments' => $investments,
            'investment' => $investment,
            'investment_titles' => $investmentTitles,
            'investment_title' => $investmentTitle,

            'has_modal' => 'yes',
            'page_name' => 'budgets.private_investment.edit'
        );

        return view('budgets.private_investment.index')->with($data);
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
        $user->authorizeRoles('College Admin');

        $this->validate($request, [
            'investment_title' => 'required',
            'cost_incurred' => 'required',
        ]);

        $investment = Investment::find($id);
        $investment->investment_title = $request->input('investment_title');
        $investment->cost_incurred = $request->input('cost_incurred');
        $investment->remarks = $request->input('remarks');

        $investment->save();


        return redirect('/budgets/private-investment');
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
        $item = Investment::find($id);
        $item->delete();
        return redirect('/budgets/private-investment');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');

        $investment = Investment::find($id);
        if ($action == "approve") {
            $investment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $investment->save();
        } elseif ($action == "disapprove") {
            $investment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $investment->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->investments as $investment) {
                                    if ($investment->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                        $investment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                        $investment->save();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/budgets/private-investment")->with('primary', 'Success');
    }

}
