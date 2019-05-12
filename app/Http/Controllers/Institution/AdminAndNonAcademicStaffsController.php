<?php

namespace App\Http\Controllers\Institution;
use App\Http\Controllers\Controller;
use App\Models\Institution\AdminAndNonAcademicStaff;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;


class AdminAndNonAcademicStaffsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['page_name' => 'institution.admin_and_non_academic_staff.list' , 'staffs' => 'abc'];
        return view('institutions.admin_and_non_academic_staff.list')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'education_levels' => AdminAndNonAcademicStaff::getEnum("EducationLevels"),
            // 'dedications' => Staff::getEnum("Dedications"),
            // 'academic_levels' => Staff::getEnum("AcademicLevels"),
            // 'staff_ranks' => AcademicStaff::getEnum("StaffRanks"),
            'page_name' => 'institution.admin_and_non_academic_staff.create'
        );

        return view('institutions.admin_and_non_academic_staff.list')->with('data' , $data);
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

        $admin_staff = new AdminAndNonAcademicStaff();

        $admin_staff->male_staff_number = $request->input('number_of_males');
        $admin_staff->female_staff_number = $request->input('number_of_females');
        $admin_staff->education_level = $request->input('education_level');

        $admin_staff->institution_id = Uuid::generate()->string;

        $admin_staff->save();

        return redirect('institutions/non-admin');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ['page_name' => 'institution.admin_and_non_academic_staff.list'];
        return view('institutions.admin_and_non_academic_staff.list')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ['page_name' => 'institution.admin_and_non_academic_staff.edit'];
        return view('institutions.admin_and_non_academic_staff.list')->with('data', $data);
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
