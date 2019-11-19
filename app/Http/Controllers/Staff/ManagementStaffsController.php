<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\ManagementStaff;
use App\Models\Staff\Staff;
use App\Models\Staff\JobTitle;
use App\Models\Staff\AdministrativeStaff;
use App\Services\HierarchyService;
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
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->managementStaffs as $managementStaff)
                    $managementStaffs[] = $managementStaff;

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
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $administrativeStaffs = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->administrativeStaffs as $administrativeStaff)
                    $administrativeStaffs[] = $administrativeStaff;

        $data = array(
            'staffs' => $administrativeStaffs,
            'employment_types' => Staff::getEnum("employment_type"),
            'dedications' => Staff::getEnum("dedication"),
            'academic_levels' => Staff::getEnum("academic_levels"),
            'levels' => ManagementStaff::getEnum("management_levels"),
            'job_titles' => JobTitle::where('staff_type', 'Management')->get(),
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
            'management_level' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');
        $administrativeStaff = AdministrativeStaff::find($request->input('staff'));
        $staff = $administrativeStaff->general;

        $managementStaff = new ManagementStaff;
        $managementStaff->management_level = $request->input('management_level');
        $managementStaff->job_title_id = $request->input('job_title');
        $managementStaff->staff_id = $staff->id;

        $college->managementStaffs()->save($managementStaff);

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
            'management_level' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $managementStaff = ManagementStaff::find($id);
        $managementStaff->management_level = $request->input('management_level');

        $staff = $managementStaff->general;
        HierarchyService::populateStaff($request, $staff);
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
