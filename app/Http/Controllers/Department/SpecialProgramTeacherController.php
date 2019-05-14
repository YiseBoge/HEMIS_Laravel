<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use App\Models\Department\SpecialProgramTeacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecialProgramTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestedType=$request->input('program_type');
        if($requestedType==null){
            $requestedType='ELIP';
        }

        $requestedStatus=$request->input('program_status');
        if($requestedStatus==null){
            $requestedStatus='COMPLETED';
        }
        //$budget_type = Budget::getEnum('budget_type')[$requestedType];

        $specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data=[
            'program_type'=>$requestedType,
            'program_status'=>$requestedStatus,
            'special_program_teachers'=>$specialProgramTeachers,
            'colleges'=>CollegeName::all(),
            'bands'=>BandName::all(),
            'page_name'=>'departments.special-program-teacher.index'
        ];
        return $data['colleges'];
        return view('departments.special_program_teacher.index')->with('data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
