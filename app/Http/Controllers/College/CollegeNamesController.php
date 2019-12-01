<?php

namespace App\Http\Controllers\College;


use App\Http\Controllers\Controller;
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

        $data = [
            'colleges' => $colleges,

            'has_modal' => 'yes',
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


        $collegeName = new CollegeName;
        $collegeName->college_name = $request->input('college_name');
        $collegeName->acronym = $request->input('college_acronym');

        $collegeName->institution_name_id = $institutionName->id;

        if ($collegeName->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $collegeName->save();

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
        return redirect('/college/college-name');
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
        $user->authorizeRoles('University Admin');

        $institutionName = $user->institution()->institutionName;
        $colleges = $institutionName->collegeNames;
        $college_name = CollegeName::findOrFail($id);
        $data = [
            'id' => $id,
            'colleges' => $colleges,
            'college_name' => $college_name->college_name,
            'college_acronym' => $college_name->acronym,

            'has_modal' => 'yes',
            'page_name' => 'administer.colleges-name.edit'
        ];
        return view('colleges.college_name.index')->with($data);
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
            'college_name' => 'required',
            'college_acronym' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $college_name = CollegeName::findOrFail($id);
        $college_name->college_name = $request->input("college_name");
        $college_name->acronym = $request->input("college_acronym");

        $college_name->save();
        return redirect('/college/college-name')->with('primary', 'Successfully Updated');


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
        $item = CollegeName::findOrFail($id);
        $item->delete();
        return redirect('/college/college-name')->with('primary', 'Successfully Deleted');
    }
}
