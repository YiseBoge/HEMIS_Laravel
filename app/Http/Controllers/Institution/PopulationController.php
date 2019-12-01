<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Population;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PopulationController extends Controller
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

        $populations = Population::all();
        $data = [
            'populations' => $populations,

            'has_modal' => 'yes',
            'page_name' => 'administer.population.index',
        ];
        return view('institutions.population.index')->with($data);
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

        $populations = Population::all();
        $ageRanges = Population::getEnum('age_range');
        $data = [
            'populations' => $populations,
            'age_ranges' => $ageRanges,

            'has_modal' => 'yes',
            'page_name' => 'administer.population.create',
        ];
        return view('institutions.population.index')->with($data);
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
            'age_range' => 'required',
            'male_number' => 'required|numeric|between:0,1000000000',
            'female_number' => 'required|numeric|between:0,1000000000'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $population = new Population();
        $population->age_range = $request->input('age_range');
        $population->male_number = $request->input('male_number');
        $population->female_number = $request->input('female_number');

        if ($population->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $population->save();

        return redirect('/population')->with('success', 'Successfully Added Population Data');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        return redirect('/population');
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

        $populations = Population::all();
        $ageRanges = Population::getEnum('age_range');
        $population = Population::find($id);
        $data = [
            'population' => $population,
            'populations' => $populations,
            'age_ranges' => $ageRanges,

            'has_modal' => 'yes',
            'page_name' => 'administer.population.edit',
        ];
        return view('institutions.population.index')->with($data);
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
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $population = Population::find($id);

        $population->male_number = $request->input("male_number");
        $population->female_number = $request->input("female_number");

        $population->save();
        return redirect('/population')->with('primary', 'Successfully Updated');
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
        $item = Population::find($id);
        $item->delete();
        return redirect('/population')->with('primary', 'Successfully Deleted');
    }
}
