<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\College\TechnicalStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TechnicalStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = null;
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = null;
        }

        $requestedLevel = $request->input('level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Level III';
        }

        $technicalStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $requestedCollege && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->technicalStaffs as $staff) {
                                if ($staff->level == $requestedLevel) {
                                    $technicalStaffs[] = $staff;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $technicalStaffs = TechnicalStaff::with('college')->get();
        }

        $data = array(
            'staffs' => $technicalStaffs,
            'bands' => BandName::all(),
            'colleges' => CollegeName::all(),
            'levels' => TechnicalStaff::getEnum('EducationLevels'),
            'page_name' => 'staff.technical_staff.index',

            "selected_band" => $requestedBand,
            "selected_college" => $requestedCollege,
            "selected_level" => $requestedLevel
        );
        return view("colleges.technical_staff.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = null;
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = null;
        }

        $requestedLevel = $request->input('level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Level III';
        }

        $technicalStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $requestedBand) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $requestedCollege && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->technicalStaffs as $staff) {
                                if ($staff->level == $requestedLevel) {
                                    $technicalStaffs[] = $staff;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $technicalStaffs = TechnicalStaff::with('college')->get();
        }

        $data = array(
            'staffs' => $technicalStaffs,
            'bands' => BandName::all(),
            'colleges' => CollegeName::all(),
            'levels' => TechnicalStaff::getEnum('EducationLevels'),
            'page_name' => 'college.technical_staff.create'
        );
        return view("staff.technical_staff.index")->with($data);
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
            'male_number' => 'required',
            'female_number' => 'required'            
        ]);

        $staff = new TechnicalStaff;
        $staff->level = $request->input('level');
        $staff->male_staff_number = $request->input('male_number');
        $staff->female_staff_number = $request->input('female_number');

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');

        $institution = $user->institution();
        
        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if($band == null){
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);            
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
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
