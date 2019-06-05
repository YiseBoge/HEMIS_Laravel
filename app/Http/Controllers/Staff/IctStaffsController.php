<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\IctStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IctStaffsController extends Controller
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
        $collegeName = $user->collegeName();

        $ictStaffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        foreach ($college->ictStaffs as $ictStaff) {
                            $ictStaffs[] = $ictStaff;
                        }
                    }
                }
            }
        } else {
            $ictStaffs = IctStaff::all();
        }
        $data = array(
            'staffs' => $ictStaffs,
            'page_name' => 'staff.ict.list'
        );
        return view('staff.ict.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => IctStaff::getEnum("StaffRanks"),
            'page_name' => 'staff.ict.create'
        );
        return view('staff.ict.create')->with($data);
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
            'expatriate' => 'required',
            'ict_staff_rank' => 'required'

        ]);

        $ictStaff = new IctStaff();

        $ictStaff->staffRank = $request->input('ict_staff_rank');
        $ictStaff->institution_id = 0;

        $staff = $ictStaff->general;
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
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $ictStaff->save();

        $ictStaff->general()->save($staff);

        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        $college->ictStaffs()->save($staff);
                    }
                }
            }
        } else {
        }

        return redirect('/staff/ict');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = array(
            'staff' => IctStaff::with('general')->find($id),
            'page_name' => 'staff.ict.details'
        );
        return view('staff.ict.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = array(
            'staff' => IctStaff::with('general')->find($id),
            'page_name' => 'staff.ict.edit'

        );
        return view('staff.ict.edit')->with($data);
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
            'expatriate' => 'required',
            'ict_staff_rank' => 'required'

        ]);

        $ictStaff = IctStaff::find($id);

        $ictStaff->staffRank = $request->input('ict_staff_rank');
        $ictStaff->institution_id = 0;

        $staff = $ictStaff->general;
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
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark');

        $ictStaff->save();

        $ictStaff->general()->save($staff);

        $user = Auth::user();
        $institution = $user->institution();
        $collegeName = $user->collegeName();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                foreach ($band->colleges as $college) {
                    if ($college->collegeName->id == $collegeName->id) {
                        $college->ictStaffs()->save($staff);
                    }
                }
            }
        } else {
        }

        return redirect('/staff/ict');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $ictStaff = IctStaff::find($id);
        $staff = $ictStaff->general;
        $ictStaff->delete();
        $staff->delete();
        return redirect('/staff/ict');
    }
}
