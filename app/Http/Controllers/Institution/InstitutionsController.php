<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\College\Budget;
use App\Models\Institution\Institution;
use App\Models\Institution\Resource;
use App\Services\InstitutionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstitutionsController extends Controller
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
        $user->authorizeRoles('University Admin');
        $institution = $user->institution();

        $institutionService = new InstitutionService($institution);

        $allGraduation = $institutionService->graduationData('All', 'All', 'All');
        $undergraduateGraduation = $institutionService->graduationData('All', 'Undergraduate', 'All');
        $postgraduateGraduation =
            $institutionService->graduationData('All', 'Post Graduate(Masters)', 'All') +
            $institutionService->graduationData('All', 'Post Doctoral', 'All') +
            $institutionService->graduationData('All', 'Health Specialty', 'All');
        $femaleGraduation = $institutionService->graduationData('Female', 'All', 'All');

        $existing = array(
            'recurrent_budget' => $institutionService->budgetByType(Budget::getEnum('budget_type')['RECURRENT']),
            'capital_budget' => $institutionService->budgetByType(Budget::getEnum('budget_type')['CAPITAL']),
            'internal_income' => $institutionService->budgetNotFromGovernment(),

            'undergraduate_graduation' => $allGraduation == 0 ? 0 : $undergraduateGraduation / $allGraduation,
            'postgraduate_graduation' => $allGraduation == 0 ? 0 : $postgraduateGraduation / $allGraduation,
            'female_graduation' => $allGraduation == 0 ? 0 : $femaleGraduation / $allGraduation,

            'academic_on_duty_male' => $institutionService->academicStaffByStatus('Male', 'On Duty'),
            'academic_on_duty_female' => $institutionService->academicStaffByStatus('Female', 'On Duty'),
            'academic_on_study_male' => $institutionService->academicStaffByStatus('Male', 'On Leave'),
            'academic_on_study_female' => $institutionService->academicStaffByStatus('Female', 'On Leave'),
            'administrative_male' => $institutionService->staff('Administrative', 'Male', false, false),
            'administrative_female' => $institutionService->staff('Administrative', 'Female', false, false),
            'technical_male' => $institutionService->staff('Technical', 'Male', false, false),
            'technical_female' => $institutionService->staff('Technical', 'Female', false, false),
        );

        $data = array(
            'institution' => $institution,
            'existing' => $existing,

            'page_name' => 'general.general_info.index'
        );
        return view("institutions.general_info.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect("/institution/general");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return redirect("/institution/general");

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/institution/general");
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
        $user->authorizeRoles('University Admin');
        if ($user->read_only) return redirect("/institution/general");

        $currentInstitution = Institution::find($id);
        $status_of_libraries = Resource::getEnum('status_of_libraries');
        $status_of_laboratories = Resource::getEnum('status_of_laboratories');
        $status_of_workshops = Resource::getEnum('status_of_workshops');

        $data = array(
            'institution' => $currentInstitution,
            'status_of_libraries' => $status_of_libraries,
            'status_of_laboratories' => $status_of_laboratories,
            'status_of_workshops' => $status_of_workshops,
            'page_name' => 'general.general_info.edit'
        );
        return view("institutions.general_info.edit")->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');
        if ($user->read_only) return redirect("/institution/general");

        $this->validate($request, [
            'campuses' => 'required|numeric|between:0,250',
            'colleges' => 'required|numeric|between:0,250',
            'schools' => 'required|numeric|between:0,250',
            'institutes' => 'required|numeric|between:0,250',
            'centers' => 'required|numeric|between:0,250',
            'faculties' => 'required|numeric|between:0,250',
            'departments' => 'required|numeric|between:0,250',
            'hospitals' => 'required|numeric|between:0,250',

            'board_members' => 'required|numeric|between:0,250',
            'vice_presidents' => 'required|numeric|between:0,250',
            'middle_level_leaders' => 'required|numeric|between:0,250',

            'community_services' => 'required|numeric|between:0,10000000',
            'male_teachers_participated' => 'required|numeric|between:0,10000000',
            'female_teachers_participated' => 'required|numeric|between:0,10000000',
            'male_benefited' => 'required|numeric|between:0,10000000',
            'female_benefited' => 'required|numeric|between:0,10000000',
            'linked_tvets' => 'required|numeric|between:0,10000000',

            'number_of_libraries' => 'required|numeric|between:0,250',
            'number_of_laboratories' => 'required|numeric|between:0,250',
            'number_of_workshops' => 'required|numeric|between:0,250',

            'status_of_libraries' => 'required',
            'status_of_laboratories' => 'required',
            'status_of_workshops' => 'required',

            'pupil_per_teacher' => 'required|numeric|between:0,10000000',
            'text_per_student' => 'required|numeric|between:0,10000000',
            'number_of_classrooms' => 'required|numeric|between:0,10000000',
            'number_of_smart_classrooms' => 'required|numeric|between:0,10000000',
        ]);

        $institution = Institution::find($id);
        $generalInformation = $institution->generalInformation;
        $communityService = $generalInformation->communityService;
        $resource = $generalInformation->resource;

        $generalInformation->campuses = $request->input('campuses');
        $generalInformation->colleges = $request->input('colleges');
        $generalInformation->schools = $request->input('schools');
        $generalInformation->institutes = $request->input('institutes');
        $generalInformation->centers = $request->input('centers');
        $generalInformation->faculties = $request->input('faculties');
        $generalInformation->departments = $request->input('departments');
        $generalInformation->hospitals = $request->input('hospitals');

        $generalInformation->board_members = $request->input('board_members');
        $generalInformation->vice_presidents = $request->input('vice_presidents');
        $generalInformation->middle_level_leaders = $request->input('middle_level_leaders');

        $communityService->community_services = $request->input('community_services');
        $communityService->male_teachers_participated = $request->input('male_teachers_participated');
        $communityService->female_teachers_participated = $request->input('female_teachers_participated');
        $communityService->male_benefited = $request->input('male_benefited');
        $communityService->female_benefited = $request->input('female_benefited');
        $communityService->linked_tvets = $request->input('linked_tvets');

        $communityService->has_spd = $request->has('has_spd');
        $communityService->has_incubation = $request->has('has_incubation');
        $communityService->has_hdp_lead = $request->has('has_hdp_lead');
        $communityService->has_ccpd_coordinator = $request->has('has_ccpd_coordinator');
        $communityService->has_elip_teachers = $request->has('has_elip_teachers');
        $communityService->has_elip_students = $request->has('has_elip_students');
        $communityService->has_career_center = $request->has('has_career_center');

        /** @var Resource $resource */
        $resource->number_of_libraries = $request->input('number_of_libraries');
        $resource->number_of_laboratories = $request->input('number_of_laboratories');
        $resource->number_of_workshops = $request->input('number_of_workshops');

        $resource->status_of_libraries = $request->input('status_of_libraries');
        $resource->status_of_laboratories = $request->input('status_of_laboratories');
        $resource->status_of_workshops = $request->input('status_of_workshops');

        $resource->pupil_per_teacher = $request->input('pupil_per_teacher');
        $resource->text_per_student = $request->input('text_per_student');
        $resource->number_of_classrooms = $request->input('number_of_classrooms');
        $resource->number_of_smart_classrooms = $request->input('number_of_smart_classrooms');
        $resource->unjustifiable_expenses = 0;

        $generalInformation->save();
        $communityService->save();
        $resource->save();

        return redirect("/institution/general")->with('primary', 'Successfully Updated General Information');
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
        $item = Institution::find($id);
        $item->delete();
        return redirect('/institution/general')->with('primary', 'Successfully Deleted');
    }
}
