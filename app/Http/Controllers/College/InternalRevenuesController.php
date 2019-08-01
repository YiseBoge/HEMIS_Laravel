<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\InternalRevenue;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InternalRevenuesController extends Controller
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

        $revenues = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->internalRevenues as $revenue) {
                            $revenues[] = $revenue;
                        }
                    }
                }
            }
        } else {
            $revenues = InternalRevenue::all();
        }

        $data = array(
            'internal_revenues' => $revenues,
            'page_name' => 'budgets.internal-revenue.index'
        );
        return view('budgets.internal_revenue.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $revenues = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->internalRevenues as $revenue) {
                            $revenues[] = $revenue;
                        }
                    }
                }
            }
        } else {
            $revenues = InternalRevenue::all();
        }

        $revenueDescriptions = InternalRevenue::getEnum('revenue_description');

        $data = array(
            'internal_revenues' => $revenues,
            'revenue_descriptions' => $revenueDescriptions,

            'has_modal' => 'yes',
            'page_name' => 'budgets.internal-revenue.create'
        );

        return view('budgets.internal_revenue.index')->with($data);
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
            'revenue_description' => 'required',
            'income' => 'required',
            'expense' => 'required',
        ]);


        $internalRevenue = new InternalRevenue();
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');

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

        $internalRevenue->college_id = $college->id;

        if ($internalRevenue->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $internalRevenue->save();

        return redirect('/budgets/internal-revenue')->with('success', 'Successfully Added Internal Revenue');
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
        $internalRevenue = InternalRevenue::find($id);

        $revenueDescriptions = InternalRevenue::getEnum('revenue_description');
        $revenueDescription = InternalRevenue::getValueKey($revenueDescriptions, $internalRevenue->revenue_description);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $revenues = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->internalRevenues as $revenue) {
                            $revenues[] = $revenue;
                        }
                    }
                }
            }
        } else {
            $revenues = InternalRevenue::all();
        }

        $data = array(
            'internal_revenues' => $revenues,
            'internal_revenue' => $internalRevenue,
            'revenue_descriptions' => $revenueDescriptions,
            'revenue_description' => $revenueDescription,

            'has_modal' => 'yes',
            'page_name' => 'budgets.internal-revenue.edit'
        );


        return view('budgets.internal_revenue.index')->with($data);
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
            'revenue_description' => 'required',
            'income' => 'required',
            'expense' => 'required',
        ]);

        $internalRevenue = InternalRevenue::find($id);
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');

        $internalRevenue->save();

        return redirect('/budgets/internal-revenue');
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
        $item = InternalRevenue::find($id);
        $item->delete();
        return redirect('/budgets/internal-revenue');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');

        $internalRevenue = InternalRevenue::find($id);
        if ($action == "approve") {
            $internalRevenue->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $internalRevenue->save();
        } elseif ($action == "disapprove") {
            $internalRevenue->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $internalRevenue->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->internalRevenues as $internalRevenue) {
                                    if ($internalRevenue->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                        $internalRevenue->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                        $internalRevenue->save();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/budgets/internal-revenue")->with('primary', 'Success');
    }


}
