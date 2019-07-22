<?php

namespace App\Http\Controllers\College;


use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CollegeNamesController extends Controller
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

        $institutionName = $user->institution()->institutionName;
        $colleges = $institutionName->collegeNames;

        $data = [
            'colleges' => $colleges,
            'page_name' => 'administer.colleges-name.index'
        ];
        return view('colleges.college_name.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $colleges = $institutionName->collegeNames;
        $bandNames = BandName::all();

        $data = [
            'colleges' => $colleges,
            'band_names' => $bandNames,
            'page_name' => 'administer.colleges-name.create'
        ];
        return view('colleges.college_name.index')->with($data);
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
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $this->validate($request, [
            'college_name' => 'required',
            'college_acronym' => 'required'
        ]);

        $institutionName = $user->institution()->institutionName;

        $bandNames = BandName::all();
        /** @var BandName $bandName */
        $bandName = $bandNames[$request->input('band_name_id')];

        $collegeName = new CollegeName;
        $collegeName->college_name = $request->input('college_name');
        $collegeName->acronym = $request->input('college_acronym');

        $institutionName->collegeNames()->save($collegeName);
        $bandName->collegeNames()->save($collegeName);

        return redirect('/college/college-name')->with('success', 'Successfully Added College Name');
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
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = CollegeName::find($id);
        $item->delete();
        return redirect('/college/college-name');
    }
}
