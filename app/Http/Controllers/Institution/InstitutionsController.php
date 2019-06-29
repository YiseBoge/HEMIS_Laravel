<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Institution;
use App\Models\Institution\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstitutionsController extends Controller
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
        $user->authorizeRoles('University Admin');
        $institution = $user->institution();

        $data = array(
            'institution' => $institution,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

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

        $this->validate($request, [
            'campuses' => 'required',
            'colleges' => 'required',
            'schools' => 'required',
            'institutes' => 'required',

            'board_members' => 'required',
            'vice_presidents' => 'required',
            'middle_level_leaders' => 'required',

            'community_services' => 'required',
            'male_teachers_participated' => 'required',
            'female_teachers_participated' => 'required',
            'male_benefited' => 'required',
            'female_benefited' => 'required',
            'linked_tvets' => 'required',

            'number_of_libraries' => 'required',
            'number_of_laboratories' => 'required',
            'number_of_workshops' => 'required',

            'status_of_libraries' => 'required',
            'status_of_laboratories' => 'required',
            'status_of_workshops' => 'required',

            'pupil_per_teacher' => 'required',
            'text_per_student' => 'required',
            'rate_of_smart_classrooms' => 'required',
        ]);

        $institution = Institution::find($id);
        $generalInformation = $institution->generalInformation;
        $communityService = $generalInformation->communityService;
        $resource = $generalInformation->resource;

        $generalInformation->campuses = $request->input('campuses');
        $generalInformation->colleges = $request->input('colleges');
        $generalInformation->schools = $request->input('schools');
        $generalInformation->institutes = $request->input('institutes');

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
        $resource->rate_of_smart_classrooms = $request->input('rate_of_smart_classrooms');

        $generalInformation->save();
        $communityService->save();
        $resource->save();

        return redirect("/institution/general");
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
