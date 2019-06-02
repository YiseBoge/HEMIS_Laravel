<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\Band\UniversityIndustryLinkage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UniversityIndustryLinkageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution();

        $requestedYear = $request->input('year');
        if ($requestedYear == null) {
            $requestedYear = 1;
        }

        $linkages = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->universityIndustryLinkages as $linkage) {
                    if ($linkage->year == $requestedYear) {
                        $linkages[] = $linkage;
                    }                    
                }
            }
        } else {
            $linkages = UniversityIndustryLinkage::with('band')->get();
        }

        $data = array(
            'linkages' => $linkages,
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),
            'page_name' => 'bands.university_industry_linkage.index',

            "selected_year" => $requestedYear
        );
        return view("bands.university_industry_linkage.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution();

        $requestedYear = $request->input('year');
        if ($requestedYear == null) {
            $requestedYear = 'Normal';
        }

        $linkages = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->universityIndustryLinkages as $linkage) {
                    if ($linkage->year == $requestedYear) {
                        $linkages[] = $linkage;
                    }                    
                }
            }
        } else {
            $linkages = UniversityIndustryLinkage::with('band')->get();
        }

        $data = array(
            'linkages' => $linkages,
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),
            'page_name' => 'bands.university_industry_linkage.create'
        );
        return view("bands.university_industry_linkage.index")->with($data);
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

        $institution = $user->institution();

        $bandName = $user->bandName;
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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
