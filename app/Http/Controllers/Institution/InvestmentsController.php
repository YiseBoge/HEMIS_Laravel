<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Investment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webpatser\Uuid\Uuid;

class InvestmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array(
            'investments' => Investment::all(),
            'page_name' => 'institution.investment.index'
        );

        return view('institutions.private_investment.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $investmentTitles = Investment::getEnum('investment_title');

        $data = array(
            'investments' => Investment::all(),
            'investment_titles' => $investmentTitles,
            'page_name' => 'institution.investment.create'
        );

        return view('institutions.private_investment.index')->with('data', $data);
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
            'investment_title' => 'required',
            'cost_incurred' => 'required',
        ]);


        $investment = new Investment();
        $investment->investment_title = $request->input('investment_title');
        $investment->cost_incurred = $request->input('cost_incurred');
        $investment->remarks = $request->input('remarks');

//        Todo remove this
        $investment->institution_id = Uuid::generate()->string;

        $investment->save();


        return redirect('/institution/private-investment');
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

        $data = array(
            'investments' => Investment::all(),
            'investment' => $investment,
            'investment_titles' => $investmentTitles,
            'investment_title' => $investmentTitle,
            'page_name' => 'institution.investment.edit'
        );

        return view('institutions.private_investment.index')->with('data', $data);
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
            'investment_title' => 'required',
            'cost_incurred' => 'required',
        ]);


        $investment = Investment::find($id);
        $investment->investment_title = $request->input('investment_title');
        $investment->cost_incurred = $request->input('cost_incurred');
        $investment->remarks = $request->input('remarks');

        $investment->save();


        return redirect('/institution/private-investment');
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
