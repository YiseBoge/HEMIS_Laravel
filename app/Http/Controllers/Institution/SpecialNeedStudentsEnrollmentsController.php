<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\SpecialNeeds;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SpecialNeedStudentsEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution();

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->specialNeeds as $enrollment) {
                $enrollments[] = $enrollment;
            }
        } else {
            $enrollments = SpecialNeeds::all();
        }

        $data = array(
            'enrollments' => $enrollments,
            'programs' => SpecialNeeds::getEnum("EducationPrograms"),
            'year_levels' => SpecialNeeds::getEnum('Years'),
            'page_name' => 'enrollment.specializing_student_enrollment.index'
        );
        return view("enrollment.special_need_students.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'need_types' => SpecialNeeds::getEnum('NeedsTypes'),
            'programs' => SpecialNeeds::getEnum("EducationPrograms"),
            'year_levels' => SpecialNeeds::getEnum('Years'),
            'page_name' => 'enrollment.special_need_students.create'
        );
        return view('enrollment.special_need_students.create')->with($data);
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
        $institution = $user->institution();

        $enrollment = new SpecialNeeds;
        $enrollment->male_students_number = $request->input('male_number');
        $enrollment->female_students_number = $request->input('female_number');
        $enrollment->type = $request->input('need_type');
        $enrollment->year = $request->input('year_level');
        $enrollment->program = $request->input('program');
        
        $institution->specialNeeds()->save($enrollment);


        return redirect("/enrollment/special-need-students");
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
