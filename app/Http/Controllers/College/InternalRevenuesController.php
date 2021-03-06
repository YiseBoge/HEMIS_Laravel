<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\InternalRevenue;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
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
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->internalRevenues as $internalRevenue)
                    $revenues[] = $internalRevenue;

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
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->internalRevenues as $internalRevenue)
                    $revenues[] = $internalRevenue;

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
            'income' => 'required|numeric|between:0,10000000',
            'expense' => 'required|numeric|between:0,10000000',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');

        $internalRevenue = new InternalRevenue();
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');

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
        return redirect('/budgets/internal-revenue');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $internalRevenue = InternalRevenue::findOrFail($id);

        $revenueDescriptions = InternalRevenue::getEnum('revenue_description');
        $revenueDescription = InternalRevenue::getValueKey($revenueDescriptions, $internalRevenue->revenue_description);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $revenues = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->internalRevenues as $internalRevenue)
                    $revenues[] = $internalRevenue;

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
        $this->validate($request, [
            'revenue_description' => 'required',
            'income' => 'required|numeric|between:0,10000000',
            'expense' => 'required|numeric|between:0,10000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $internalRevenue = InternalRevenue::findOrFail($id);
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');
        $internalRevenue->approval_status = "Pending";

        $internalRevenue->save();

        return redirect('/budgets/internal-revenue')->with('primary', 'Successfully Updated');
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
        $item = InternalRevenue::findOrFail($id);
        $item->delete();
        return redirect('/budgets/internal-revenue')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');

        if ($action == "disapprove") {
            $internalRevenue = InternalRevenue::findOrFail($id);
            $internalRevenue->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $internalRevenue->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    ApprovalService::approveData($college->internalRevenues);
                }
            }
        }
        return redirect("/budgets/internal-revenue")->with('primary', 'Success');
    }


}
