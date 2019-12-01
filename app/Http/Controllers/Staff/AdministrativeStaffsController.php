<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\AdministrativeStaff;
use App\Models\Staff\JobTitle;
use App\Models\Staff\Staff;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdministrativeStaffsController extends Controller
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

        $adminStaffs = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->administrativeStaffs as $adminStaff)
                    $adminStaffs[] = $adminStaff;

        $data = array(
            'staffs' => $adminStaffs,
            'page_name' => 'staff.administrative.list'
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
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => AdministrativeStaff::getEnum("StaffRanks"),
            'job_titles' => JobTitle::where('staff_type', 'Administrative')->get(),
            'job_levels' => JobTitle::getEnum('Levels'),
            'page_name' => 'staff.administrative.create'
        );
        return view('staff.administrative.create')->with($data);
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
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required|regex:/(09)[0-9]{8}/',
            'nationality' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'job_title' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');
        $staff = new Staff;
        HierarchyService::populateStaff($request, $staff);

        $administrativeStaff = new AdministrativeStaff;
        $administrativeStaff->job_title_id = $request->input('job_title');

        $college->administrativeStaffs()->save($administrativeStaff);
        $administrativeStaff = AdministrativeStaff::find($administrativeStaff->id);
        $administrativeStaff->general()->save($staff);

        return redirect('/staff/administrative')->with('success', 'Successfully Added Administrative Staff');
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
            'staff' => AdministrativeStaff::with('general')->find($id),
            'page_name' => 'staff.administrative.details'
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
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => AdministrativeStaff::with('general')->find($id),
            'job_titles' => JobTitle::where('staff_type', 'Administrative')->get(),
            'page_name' => 'staff.administrative.edit'
        );
        return view('staff.administrative.edit')->with($data);
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
            'birth_date' => 'required|date|before:now',
            'sex' => 'required',
            'phone_number' => 'required|regex:/(09)[0-9]{8}/',
            'nationality' => 'required',
            'job_title' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $administrativeStaff = AdministrativeStaff::find($id);
        $administrativeStaff->job_title_id = $request->input('job_title');
        $administrativeStaff->save();

        $staff = $administrativeStaff->general;
        HierarchyService::populateStaff($request, $staff);
        $administrativeStaff->general()->save($staff);

        return redirect('/staff/administrative')->with('primary', 'Successfully Updated');

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
        $item = AdministrativeStaff::find($id);
        $item->delete();
        return redirect('/staff/administrative')->with('primary', 'Successfully Deleted');
    }
}
