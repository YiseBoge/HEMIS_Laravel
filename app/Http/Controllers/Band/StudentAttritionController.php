<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band\BandName;
use App\Models\Institution\Institution;
use App\Models\Band\Band;
use App\Models\Band\StudentAttrition;
use Illuminate\Support\Facades\Auth;

class StudentAttritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='REGULAR';
        }

        $requestedType=$request->input('type');
        if($requestedType==null){
            $requestedType='CET';
        }

        $requestedCase=$request->input('case');
        if($requestedCase==null){
            $requestedCase='Academic Dismissals With Readmission';
        }

        $filteredAttritions = array();
        $attritions = StudentAttrition::with('band')->get();

        foreach ($attritions as $attrition ){

            if($attrition->program==$requestedProgram && $attrition->type == $requestedType && $attrition->case == $requestedCase){
                $filteredAttritions[]=$attrition;
            }
        }
        

        $data = array(
            'attritions' => $filteredAttritions,
            'bands' => BandName::all(),
            'programs' => StudentAttrition::getEnum('EducationPrograms'),
            'types' => StudentAttrition::getEnum('Types'),
            'cases' => StudentAttrition::getEnum('Cases'),
            'page_name' => 'bands.student_attritions.index'
        );
        return view("bands.student_attrition.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'bands' => BandName::all(),
            'programs' => StudentAttrition::getEnum('EducationPrograms'),
            'types' => StudentAttrition::getEnum('Types'),
            'cases' => StudentAttrition::getEnum('Cases'),
            'page_name' => 'bands.student_attritions.create'
        );
        return view("bands.student_attrition.create")->with($data);
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
            'male_number' => 'required',
            'female_number' => 'required',
        ]);

        $attrition = new StudentAttrition;
        $attrition->program = $request->input('program');
        $attrition->type = $request->input('type');
        $attrition->case = $request->input('case');
        $attrition->male_students_number = $request->input('male_number');
        $attrition->female_students_number = $request->input('female_number');

        $user = Auth::user();

        $institution = Institution::where('id', $user->institution_id)->first();

        $bandName = BandName::where('band_name', $request->input("band"))->first();
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);            
            $bandName->band()->save($band);
        }

        $band->studentAttritions()->save($attrition);

        return redirect("/institution/student-attrition");
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
