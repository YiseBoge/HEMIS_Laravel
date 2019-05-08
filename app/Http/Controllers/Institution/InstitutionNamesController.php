<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Institution\InstitutionName;

/**
 * A class for the Admin to manage all allowable Institution Names
 */
class InstitutionNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $institutions=InstitutionName::all();
        return view('institutions.institution_name.index')->with('institutions',$institutions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('institutions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'institution_name'=>'required',
        'institution_acronym'=>'required'
      ]);

      $institutionName= new InstitutionName;
      $institutionName->institution_name=$request->input('institution_name');
      $institutionName->acronym=$request->input('institution_acronym');
      $institutionName->save();

      return redirect('/institution');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('institutions.details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('institutions.edit');
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
