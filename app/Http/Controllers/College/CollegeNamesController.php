<?php

namespace App\Http\Controllers\College;



use App\Http\Controllers\Controller;
use App\Models\College\CollegeName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CollegeNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $colleges=CollegeName::all();
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $colleges=CollegeName::all();
        $data = [
            'colleges' => $colleges,
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('University Admin');

        $this->validate($request, [
            'college_name' => 'required',
            'college_acronym' => 'required'
        ]);

        $collegeName = new CollegeName;
        $collegeName->college_name = $request->input('college_name');
        $collegeName->acronym = $request->input('college_acronym');
        $collegeName->save();

        return redirect('/college/college-name');
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
