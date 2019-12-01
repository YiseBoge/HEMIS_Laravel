<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\AdministrativeStaff;
use App\Models\Staff\IctStaff;
use App\Models\Staff\IctStaffType;
use App\Models\Staff\Staff;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class IctStaffsController extends Controller
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

        $ictStaffs = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->ictStaffs as $ictStaff)
                    $ictStaffs[] = $ictStaff;

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
            'employment_types' => Staff::getEnum("EmploymentTypes"),
            'dedications' => Staff::getEnum("Dedications"),
            'academic_levels' => Staff::getEnum("AcademicLevels"),
            'staff_ranks' => IctStaff::getEnum("StaffRanks"),
            'ict_types' => IctStaffType::all(),
            'page_name' => 'staff.ict.create'
        );
        return view('staff.ict.create')->with($data);
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
            'ict_type' => 'required',
            'staff' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');
        $administrativeStaff = AdministrativeStaff::find($request->input('staff'));
        $staff = $administrativeStaff->general;

        $ictStaff = new IctStaff();
        $ictStaff->ict_staff_type_id = $request->input('ict_type');
        $ictStaff->staff_id = $staff->id;

        $college->ictStaffs()->save($ictStaff);

        return redirect('/staff/ict')->with('success', 'Successfully Added ICT Staff');
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
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');

        $data = array(
            'staff' => IctStaff::with('general')->find($id),
            'ict_types' => IctStaffType::all(),
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
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ict_type' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $ictStaff = IctStaff::findOrFail($id);
        $ictStaff->ict_staff_type_id = $request->input('ict_type');
        $ictStaff->save();

        return redirect('/staff/ict')->with('primary', 'Successfully Updated');
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
        $item = IctStaff::findOrFail($id);
        $item->delete();
        return redirect('/staff/ict')->with('primary', 'Successfully Deleted');
    }
}
