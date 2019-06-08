<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\Investment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InvestmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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

        return view('budgets.private_investment.index')->with('data', $data);
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
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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
            'page_name' => 'budgets.investment.create'
        );

        return view('budgets.private_investment.index')->with('data', $data);
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

        $investment->save();

        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        $college->investments()->save($investment);
                    }
                }
            }
        } else {
        }


        return redirect('/budgets/private-investment');
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
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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
            'page_name' => 'budgets.private_investment.edit'
        );

        return view('budgets.private_investment.index')->with('data', $data);
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
     */
    public function destroy($id)
    {
        //
    }
}
