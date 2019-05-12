<?php

namespace App\Http\Controllers\College;



use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use Illuminate\Http\Request;

class CollegeNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colleges=CollegeName::all();
        $data=['colleges'=>$colleges,'page_name'=>'colleges.colleges-name.index'];
        return view('colleges.college_name.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colleges=CollegeName::all();
        $data=['colleges'=>$colleges,'page_name'=>'colleges.colleges-name.create'];
        return view('colleges.college_name.index')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
