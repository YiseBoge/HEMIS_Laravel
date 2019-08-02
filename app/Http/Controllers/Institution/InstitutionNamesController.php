<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\CommunityService;
use App\Models\Institution\GeneralInformation;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\Resource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * A class for the Admin to manage all allowable Institution Names
 */
class InstitutionNamesController extends Controller
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

        $institutions = InstitutionName::all();
        $data = [
            'institutions' => $institutions,
            'page_name' => 'administer.institution-name.index'
        ];
        return view('institutions.institution_name.index')->with($data);
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

        $institutions = InstitutionName::all();
        $data = [
            'institutions' => $institutions,

            'has_modal' => 'yes',
            'page_name' => 'administer.institution-name.create'
        ];
        return view('institutions.institution_name.index')->with($data);
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
            'institution_name' => 'required',
            'institution_acronym' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $instance = $user->currentInstance;

        $institutionName = new InstitutionName;
        $institutionName->institution_name = $request->input('institution_name');
        $institutionName->acronym = $request->input('institution_acronym');
        $institutionName->is_private = $request->has('is_private');

        if ($institutionName->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $institutionName->save();


        $generalInformation = new GeneralInformation();
        $communityService = new CommunityService();
        $resource = new Resource();

        $generalInformation->save();
        $communityService->save();
        $resource->save();

        $generalInformation->communityService()->associate($communityService)->save();
        $generalInformation->resource()->associate($resource)->save();

        $institution = new Institution();
        $institution->institution_name_id = $institutionName->id;
        $institution->instance_id = $instance->id;

        $generalInformation->institution()->save($institution);


        return redirect('/institution/institution-name')->with('success', 'Successfully Added Institution Name');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        return redirect('/institution/institution-name');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function edit($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $institutions = InstitutionName::all();
        $institution = InstitutionName::find($id);
        // return $institution; 
        $data = [
            'institutions' => $institutions,
            'current_institution' => $institution,

            'has_modal' => 'yes',
            'page_name' => 'administer.institution-name.edit'
        ];

        return view('institutions.institution_name.index')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public
    function update(Request $request, $id)
    {
        $this->validate($request, [
            'institution_name' => 'required',
            'institution_acronym' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');
        $instance = $user->currentInstance;

        $institutionName = InstitutionName::find($id);
        $institutionName->institution_name = $request->input('institution_name');
        $institutionName->acronym = $request->input('institution_acronym');
        $institutionName->is_private = $request->has('is_private');
        $institutionName->save();

        return redirect('/institution/institution-name')->with('primary', 'Successfully Edited Institution Name');

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
        $item = InstitutionName::find($id);
        $item->delete();
        return redirect('/institution/institution-name');
    }
}
