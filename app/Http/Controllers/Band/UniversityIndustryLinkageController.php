<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\Institution\Institution;
use App\Models\Band\Band;
use App\Models\Band\UniversityIndustryLinkage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UniversityIndustryLinkageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'linkages' => UniversityIndustryLinkage::with('band')->get(),
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),
            'page_name' => 'bands.university_industry_linkage.index'
        );
        return view("bands.university_industry_linkage.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'linkages' => UniversityIndustryLinkage::with('band')->get(),
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),
            'page_name' => 'bands.university_industry_linkage.create'
        );
        return view("bands.university_industry_linkage.index")->with($data);
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
            'training_area' => 'required',
            'number_of_students' => 'required',
            'industry_number' => 'required'            
        ]);

        $linkage = new UniversityIndustryLinkage;
        $linkage->year = $request->input('year');
        $linkage->number_of_industry_links = $request->input('industry_number');
        $linkage->number_of_students = $request->input('number_of_students');
        $linkage->training_area = $request->input('training_area');

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

        $band->universityIndustryLinkages()->save($linkage);

        return redirect("/institution/university-industry-linkage");
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
