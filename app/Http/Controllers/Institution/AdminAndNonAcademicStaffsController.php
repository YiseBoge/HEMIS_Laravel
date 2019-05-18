<?php

namespace App\Http\Controllers\Institution;
use App\Http\Controllers\Controller;
use App\Models\Institution\AdminAndNonAcademicStaff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;


class AdminAndNonAcademicStaffsController extends Controller
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

        $adminAndNonAcademics = array();

        if ($institution != null) {
            foreach ($institution->adminAndNonAcademicStaff as $adminAndNonAcademic) {
                $adminAndNonAcademics[] = $adminAndNonAcademic;
            }
        } else {
            $adminAndNonAcademics = AdminAndNonAcademicStaff::all();
        }
        $data = ['staffs' => $adminAndNonAcademics,
                 'page_name' => 'institution.admin_and_non_academic_staff.index'];
        return view('institutions.admin_and_non_academic_staff.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'staffs' => AdminAndNonAcademicStaff::all(),
            'education_levels' => AdminAndNonAcademicStaff::getEnum("EducationLevels"),
            'page_name' => 'institution.admin_and_non_academic_staff.create'
        );

        return view('institutions.admin_and_non_academic_staff.index')->with('data' , $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        die("asfg");
        $this->validate($request, [
            'number_of_males' => 'required',
            'number_of_females' => 'required',
        ]);

        $user = Auth::user();

        $institution = $user->institution();

        $admin_staff = new AdminAndNonAcademicStaff();

        $admin_staff->male_staff_number = $request->input('number_of_males');
        $admin_staff->female_staff_number = $request->input('number_of_females');
        $admin_staff->education_level = $request->input('education_level');

        $admin_staff->institution_id = Uuid::generate()->string;

        $admin_staff->save();

        return redirect('institution/non-admin');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = ['staffs' => AdminAndNonAcademicStaff::all(),
        'education_levels' => AdminAndNonAcademicStaff::getEnum("EducationLevels"),
            'page_name' => 'institution.admin_and_non_academic_staff.edit'];
        return view('institutions.admin_and_non_academic_staff.index')->with('data', $data);
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
