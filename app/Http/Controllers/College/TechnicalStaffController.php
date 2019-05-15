<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use App\Models\Institution\Institution;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\College\TechnicalStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TechnicalStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'staffs' => TechnicalStaff::with('college')->get(),
            'bands' => BandName::all(),
            'colleges' => CollegeName::all(),
            'levels' => TechnicalStaff::getEnum('EducationLevels'),
            'page_name' => 'college.technical_staff.index'
        );
        return view("colleges.technical_staff.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'staffs' => TechnicalStaff::with('college')->get(),
            'bands' => BandName::all(),
            'colleges' => CollegeName::all(),
            'levels' => TechnicalStaff::getEnum('EducationLevels'),
            'page_name' => 'college.technical_staff.create'
        );
        return view("colleges.technical_staff.index")->with($data);
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
            'female_number' => 'required'            
        ]);

        $staff = new TechnicalStaff;
        $staff->level = $request->input('level');
        $staff->male_staff_number = $request->input('male_number');
        $staff->female_staff_number = $request->input('female_number');

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

        $collegeName = CollegeName::where('college_name', $request->input("college"))->first();
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if($college == null){
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = 'None';
            $college->college_name_id = 0;
            $band->colleges()->save($college);           
            $collegeName->college()->save($college);
        }

        $college->technicalStaffs()->save($staff);

        return redirect("/staff/technical-staff");
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
