<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\EmergingRegion;
use App\Models\Institution\PastoralRegion;
use App\Models\Institution\RegionName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SpecialRegionsEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();


        $requestedProgram=$request->input('program');
        if($requestedProgram==null){
            $requestedProgram='Regular';
        }

        $requestedYearLevel=$request->input('year_level');
        if($requestedYearLevel==null){
            $requestedYearLevel='1';
        }

        $requestedType=$request->input('region_type');
        if($requestedType==null){
            $requestedType='Emerging Regions';
        }

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->emergingRegion as $enrollment) {
                $enrollments[] = $enrollment;
            }
        } else {
            $enrollments = EmergingRegion::all();
        }

        $data = array(
            'enrollments' => $enrollments,
            'regions' => RegionName::all(),
            'programs' => EmergingRegion::getEnum("EducationPrograms"),
            'year_levels' => EmergingRegion::getEnum('Years'),

            'selected_program' => $requestedProgram,
            'selected_year' => $requestedYearLevel,
            'selected_type' => $requestedType,
            'page_name' => 'enrollment.special_region_students.index'
        );
        return view("enrollment.special_region_students.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $data = array(
            'regions' => RegionName::all(),
            'programs' => EmergingRegion::getEnum("EducationPrograms"),
            'year_levels' => EmergingRegion::getEnum('Years'),
            'page_name' => 'enrollment.special_region_students.create'
        );
        return view('enrollment.special_region_students.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'male_number' => 'required',
            'female_number' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();


        if($request->input('region_type') == 'emerging_regions'){
            $enrollment = new EmergingRegion;
        }else{
            $enrollment = new PastoralRegion;
        }

        $enrollment->male_number = $request->input('male_number');
        $enrollment->female_number = $request->input('female_number');
        $enrollment->year_level = $request->input('year_level');
        $enrollment->education_program = $request->input('program');
        $enrollment->region_name_id = 0; 
        $regionName = RegionName::where('name', $request->input("region"))->first();
        if($request->input('region_type') == 'emerging_regions'){
            $institution->emergingRegion()->save($enrollment);                                   
            $regionName->emergingRegion()->save($enrollment); 
        }else{
            $institution->pastoralRegion()->save($enrollment);   
            $regionName->pastoralRegion()->save($enrollment);  
        }   

        return redirect("/enrollment/special-region-students");
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
