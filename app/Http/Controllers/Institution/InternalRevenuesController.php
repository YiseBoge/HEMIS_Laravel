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
        $data = ['internal_revenues' => InternalRevenue::all()];

        return view('institutions.internal_revenue.index')->with('data', $data);
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
