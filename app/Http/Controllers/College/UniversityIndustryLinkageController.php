<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\Band\UniversityIndustryLinkage;
use App\Models\College\College;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UniversityIndustryLinkageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $linkages = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->universityIndustryLinkages as $linkage) {
                                $linkages[] = $linkage;
                            }
                        }

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
            'page_name' => 'students.university_industry_linkage.index'
        );
        return view("bands.university_industry_linkage.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $linkages = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->universityIndustryLinkages as $linkage) {
                                $linkages[] = $linkage;
                            }
                        }

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

            'page_name' => 'students.university_industry_linkage.create'
        );
        return view("bands.university_industry_linkage.index")->with($data);
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('College Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->universityIndustryLinkages()->save($linkage);

        return redirect("/student/university-industry-linkage");
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
