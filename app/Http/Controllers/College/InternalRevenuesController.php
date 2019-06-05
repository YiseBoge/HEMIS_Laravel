<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\InternalRevenue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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
        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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

        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        $college->internalRevenues()->save($internalRevenue);
                    }
                }
            }
        } else {
        }


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

        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

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
