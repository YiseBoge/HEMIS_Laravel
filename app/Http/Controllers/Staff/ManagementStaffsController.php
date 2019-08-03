<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Staff\ManagementStaff;
use App\Models\Staff\Staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManagementStaffsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles(['College Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $managementStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->managementStaffs as $managementStaff) {
                            $managementStaffs[] = $managementStaff;
                        }
                    }
                }
            }
        } else {
            $managementStaffs = ManagementStaff::all();
        }
        $data = array(
            'staffs' => $managementStaffs,
            'page_name' => 'staff.management.list'
        );
        return view('staff.management.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'employment_types' => Staff::getEnum("employment_type"),
            'dedications' => Staff::getEnum("dedication"),
            'academic_levels' => Staff::getEnum("academic_levels"),
            'levels' => ManagementStaff::getEnum("management_levels"),
            'page_name' => 'staff.management.create'
        );
        return view('staff.management.create')->with($data);
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
            'name' => 'required',
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required',
            'service_year' => 'required',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required'
        ]);

        $staff = new Staff;
        $staff->name = $request->input('name');
        $staff->birth_date = $request->input('birth_date');
        $staff->sex = $request->input('sex');
        $staff->phone_number = $request->input('phone_number');
        $staff->nationality = $request->input('nationality');
        $staff->job_title = $request->input('job_title');
        $staff->salary = $request->input('salary');
        $staff->service_year = $request->input('service_year');
        $staff->employment_type = $request->input('employment_type');
        $staff->dedication = $request->input('dedication');
        $staff->academic_level = $request->input('academic_level');
        $staff->is_expatriate = $request->has('expatriate');
        $staff->is_from_other_region = $request->has('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $managementStaff = new ManagementStaff;
        $managementStaff->management_level = $request->input('management_level');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->managementStaffs()->save($managementStaff);
        $managementStaff = ManagementStaff::find($managementStaff->id);
        $managementStaff->general()->save($staff);

        return redirect('/staff/management')->with('success', 'Successfully Added Management Staff');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => ManagementStaff::with('general')->find($id),
            'page_name' => 'staff.management.details'
        );
        return view('staff.management.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => ManagementStaff::with('general')->find($id),
            'page_name' => 'staff.management.edit'
        );
        return view('staff.management.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'birth_date' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required',
            'service_year' => 'required',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'management_level' => 'required'

        ]);

        $managementStaff = ManagementStaff::find($id);
        $managementStaff->management_level = $request->input('management_level');

        $staff = $managementStaff->general;
        $staff->name = $request->input('name');
        $staff->birth_date = $request->input('birth_date');
        $staff->sex = $request->input('sex');
        $staff->phone_number = $request->input('phone_number');
        $staff->nationality = $request->input('nationality');
        $staff->job_title = $request->input('job_title');
        $staff->salary = $request->input('salary');
        $staff->service_year = $request->input('service_year');
        $staff->employment_type = $request->input('employment_type');
        $staff->dedication = $request->input('dedication');
        $staff->academic_level = $request->input('academic_level');
        $staff->is_expatriate = $request->input('expatriate');
        $staff->is_from_other_region = $request->input('other_region');
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $college->managementStaffs()->save($managementStaff);
        $managementStaff = ManagementStaff::find($managementStaff->id);
        $managementStaff->general()->save($staff);

        return redirect('/staff/management')->with('primary', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = ManagementStaff::find($id);
        $item->delete();
        return redirect('/staff/management')->with('primary', 'Successfully Deleted');
    }
}
