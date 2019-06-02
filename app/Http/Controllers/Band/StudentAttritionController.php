<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\Band\StudentAttrition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StudentAttritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $institution = $user->institution();

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'REGULAR';
        }

        $requestedType = $request->input('type');
        if ($requestedType == null) {
            $requestedType = 'CET';
        }

        $requestedCase = $request->input('case');
        if ($requestedCase == null) {
            $requestedCase = 'Academic Dismissals With Readmission';
        }

        $attritions = array();
        $attritions = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->studentAttritions as $attrition) {
                    if ($attrition->program == $requestedProgram && $attrition->type == $requestedType && $attrition->case == $requestedCase) {
                        $attritions[] = $attrition;
                    }
                }
            }
        } else {
            $attritions = StudentAttrition::with('band')->get();
        }

        $data = array(
            'attritions' => $attritions,
            'bands' => BandName::all(),
            'programs' => StudentAttrition::getEnum('EducationPrograms'),
            'types' => StudentAttrition::getEnum('Types'),
            'cases' => StudentAttrition::getEnum('Cases'),
            'page_name' => 'bands.student_attritions.index',

            "selected_program" => $requestedProgram,
            "selected_type" => $requestedType,
            "selected_case" => $requestedCase,
        );
        return view("bands.student_attrition.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
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
     * @param Request $request
     * @return Response
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

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
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
     */
    public function destroy($id)
    {
        //
    }
}
