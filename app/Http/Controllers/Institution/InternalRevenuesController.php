<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\InternalRevenue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webpatser\Uuid\Uuid;

class InternalRevenuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array(
            'internal_revenues' => InternalRevenue::all(),
            'page_name' => 'institution.internal-revenue.index'
        );
        return view('institutions.internal_revenue.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $revenueDescriptions = InternalRevenue::getEnum('revenue_description');

        $data = array(
            'internal_revenues' => InternalRevenue::all(),
            'revenue_descriptions' => $revenueDescriptions,
            'page_name' => 'institution.internal-revenue.create'
        );

        return view('institutions.internal_revenue.index')->with('data', $data);
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
            'revenue_description' => 'required',
            'income' => 'required',
            'expense' => 'required',
        ]);


        $internalRevenue = new InternalRevenue();
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');

//        Todo remove this
        $internalRevenue->institution_id = Uuid::generate()->string;

        $internalRevenue->save();


        return redirect('/institution/internal-revenue');
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

        $data = array(
            'internal_revenues' => InternalRevenue::all(),
            'internal_revenue' => $internalRevenue,
            'revenue_descriptions' => $revenueDescriptions,
            'revenue_description' => $revenueDescription,
            'page_name' => 'institution.internal-revenue.edit'
        );


        return view('institutions.internal_revenue.index')->with('data', $data);
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
            'revenue_description' => 'required',
            'income' => 'required',
            'expense' => 'required',
        ]);


        $internalRevenue = InternalRevenue::find($id);
        $internalRevenue->revenue_description = $request->input('revenue_description');
        $internalRevenue->income = $request->input('income');
        $internalRevenue->expense = $request->input('expense');

        $internalRevenue->save();


        return redirect('/institution/internal-revenue');
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
