<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band\BandName;
use App\Models\Institution\Institution;
use App\Models\Band\Band;
use App\Models\Band\Research;
use Illuminate\Support\Facades\Auth;

class ResearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'researchs' => Research::with('band')->get(),
            'bands' => BandName::all(),
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'bands.research.index'
        );
        return view("bands.research.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'bands' => BandName::all(),
            'completions' => Research::getEnum('Completions'),
            'types' => Research::getEnum('Types'),
            'page_name' => 'bands.research.create'
        );
        return view("bands.research.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'female_number' => 'required',
            'budget' => 'required',
            'external_budget' => 'required',
            'male_participating_number' => 'required',
            'female_participating_number' => 'required',
            'other_male_number' => 'required',
            'other_female_number' => 'required'
        ]);

        $research = new Research;
        $research->number = $request->input('number');
        $research->male_teachers_participating_number = $request->input('male_participating_number');
        $research->female_teachers_participating_number = $request->input('female_participating_number');
        $research->female_researchers_number = $request->input('female_number');
        $research->male_researchers_other_number = $request->input('other_male_number');
        $research->female_researchers_other_number = $request->input('other_male_number');
        $research->budget_allocated = $request->input('other_male_number');
        $research->budget_from_externals = $request->input('other_male_number');
        $research->status = $request->input('status');
        $research->type = $request->input('type');

        $user = Auth::user();

        $institution = Institution::where('id', $user->institution_id)->first();

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);            
            $bandName->band()->save($band);
        }

        $band->researchs()->save($research);

        return redirect("/band/researches");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
