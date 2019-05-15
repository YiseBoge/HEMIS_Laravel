<?php

namespace App\Http\Controllers\Institution;
use App\Http\Controllers\Controller;
use App\Models\Institution\AgeEnrollment;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class AgeEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['enrollemnt_info' => AgeEnrollment::all(),
                 'age_range'=>AgeEnrollment::getEnum('Ages'),
                 'page_name' => 'institution.age_enrollment.index'];
        return view('institutions.age_enrollment.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['enrollemnt_info' => AgeEnrollment::all(),
                 'age_range'=>AgeEnrollment::getEnum('Ages'),
                 'page_name' => 'institution.age_enrollment.create'];
        return view('institutions.age_enrollment.index')->with('data', $data);
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
            'number_of_males' => 'required',
            'number_of_females' => 'required',
        ]);

        $age_enrollment = new AgeEnrollment();
         $age_enrollment->male_students_number = $request->input('number_of_males');
         $age_enrollment->female_students_number = $request->input('number_of_females');

         $age_enrollment->age = $request->input('age_range');

         $age_enrollment->institution_id = Uuid::generate()->string;

         $age_enrollment->save();

         return redirect('institution/age-enrollment');
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
