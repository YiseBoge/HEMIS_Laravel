<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Staff\Staff;
use App\Models\Staff\AdministrativeStaff;

class AdministrativeStaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array(
            'staffs' => AdministrativeStaff::with('general')->get(),
            'page_name' => 'administrative.list'
        );

        // return $data['staffs'][0];
        return view('staff.administrative.list')->with($data);
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
            'staff_ranks' => AdministrativeStaff::getEnum("StaffRanks"),
            'page_name' => 'administrative.create'
        );
        return view('staff.administrative.create')->with($data);
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
            'expatriate' => 'nullable',
            'administrative_staff_rank' => 'required',
        ]);

        if($request->get('expatriate') == null){
            $expatriate = 0;
        }
        else{
            $expatriate = 1;
        }

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
        $staff->is_expatriate = $expatriate;
        $staff->salary = $request->input('salary');
        $staff->remarks = $request->input('additional_remark') == null ? " " : $request->input('additional_remark'); 

        $administrativeStaff = new AdministrativeStaff;
        $administrativeStaff->staffRank = $request->input('administrative_staff_rank');
        $administrativeStaff->institution_id = 0;       

        $administrativeStaff->save();

        $administrativeStaff = AdministrativeStaff::find($administrativeStaff->id);

        $administrativeStaff->general()->save($staff);
        
        return redirect('/staff/administrative');
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
            'staff' => AdministrativeStaff::with('general')->find($id),
            'page_name' => 'administrative.details'
        );
        return view('staff.administrative.details')->with($data);
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
            'staff' => AdministrativeStaff::with('general')->find($id),
            'page_name' => 'administrative.edit'
        );
        return view('staff.administrative.edit')->with($data);
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
            'administrative_staff_rank' => 'required'
            
        ]);

        $administrativeStaff = AdministrativeStaff::find($id);

        $administrativeStaff->staffRank = $request->input('administrative_staff_rank');
        $administrativeStaff->institution_id = 0;

        $staff = $administrativeStaff->general;
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

        $administrativeStaff->save();

        $administrativeStaff->general()->save($staff);
        
        return redirect('/staff/administrative');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $administrativeStaff = AdministrativeStaff::find($id);
        $staff = $administrativeStaff->general;
        $administrativeStaff->delete();
        $staff->delete();
        return redirect('/staff/administrative');
    }
}
