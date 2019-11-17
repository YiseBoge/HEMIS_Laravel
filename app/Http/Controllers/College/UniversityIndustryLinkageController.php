<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\Band\UniversityIndustryLinkage;
use App\Models\College\College;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UniversityIndustryLinkageController extends Controller
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
        $user->authorizeRoles(['College Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $linkages = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->universityIndustryLinkages as $linkage)
                    $linkages[] = $linkage;

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
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $linkages = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->universityIndustryLinkages as $linkage)
                    $linkages[] = $linkage;

        $data = array(
            'linkages' => $linkages,
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),

            'has_modal' => 'yes',
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
            'number_of_students' => 'required|numeric|between:0,1000000000',
            'industry_number' => 'required|numeric|between:0,1000000000'
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');

        $linkage = new UniversityIndustryLinkage;
        $linkage->year = $request->input('year');
        $linkage->number_of_industry_links = $request->input('industry_number');
        $linkage->number_of_students = $request->input('number_of_students');
        $linkage->training_area = $request->input('training_area');

        $linkage->college_id = $college->id;

        if ($linkage->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $linkage->save();

        return redirect("/student/university-industry-linkage")->with('success', 'Successfully Added Industry Linkage');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/student/university-industry-linkage");
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('College Admin');

        $universityIndustryLinkage = UniversityIndustryLinkage::find($id);

        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $linkages = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->universityIndustryLinkages as $linkage)
                    $linkages[] = $linkage;

        $data = array(
            'id' => $id,
            'linkages' => $linkages,
            'bands' => BandName::all(),
            'years' => UniversityIndustryLinkage::getEnum('Years'),
            'number_of_linked_indutries' => $universityIndustryLinkage->number_of_industry_links,
            'training_area' => $universityIndustryLinkage->training_area,
            'number_of_students' => $universityIndustryLinkage->number_of_students,
            'year' => $universityIndustryLinkage->year,

            'has_modal' => 'yes',
            'page_name' => 'students.university_industry_linkage.edit'
        );
        return view("bands.university_industry_linkage.index")->with($data);
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
            'training_area' => 'required',
            'number_of_students' => 'required|numeric|between:0,1000000000',
            'industry_number' => 'required|numeric|between:0,1000000000'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('College Admin');

        $universityIndustryLinkage = UniversityIndustryLinkage::find($id);

        $universityIndustryLinkage->number_of_industry_links = $request->input('industry_number');
        $universityIndustryLinkage->training_area = $request->input('training_area');
        $universityIndustryLinkage->number_of_students = $request->input('number_of_students');
        $universityIndustryLinkage->approval_status = "Pending";

        $universityIndustryLinkage->save();

        return redirect("/student/university-industry-linkage")->with('primary', 'Successfully Updated');

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
        $item = UniversityIndustryLinkage::find($id);
        $item->delete();
        return redirect('/student/university-industry-linkage')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');

        if ($action == "disapprove") {
            $linkage = UniversityIndustryLinkage::find($id);
            $linkage->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $linkage->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                ApprovalService::approveData($college->universityIndustryLinkages);
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/student/university-industry-linkage")->with('success', 'Successfully Approved Industry Linkages');
    }

}
