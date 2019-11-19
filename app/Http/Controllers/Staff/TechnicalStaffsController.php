<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\Staff;
use App\Models\Staff\TechnicalStaff;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TechnicalStaffsController extends Controller
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $technicalStaffs = array();
        /** @var College $college */
        foreach ($institution->colleges as $college)
            if ($college->collegeName->id == $collegeName->id)
                foreach ($college->technicalStaffs as $technicalStaff)
                    $technicalStaffs[] = $technicalStaff;

        $data = array(
            'staffs' => $technicalStaffs,
            'page_name' => 'staff.technical.list'
        );
        return view('staff.technical.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $data = array(
            'employment_types' => Staff::getEnum("employment_type"),
            'dedications' => Staff::getEnum("dedication"),
            'academic_levels' => Staff::getEnum("academic_levels"),
            'staff_ranks' => TechnicalStaff::getEnum("staff_rank"),
            'page_name' => 'staff.technical.create'
        );
        return view('staff.technical.create')->with($data);
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
            'job_title' => 'required',
            'salary' => 'required|numeric|between:0,1000000000',
            'service_year' => 'required|numeric|between:0,100',
            'employment_type' => 'required',
            'dedication' => 'required',
            'academic_level' => 'required',
            'technical_staff_rank' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;

        $college = HierarchyService::getCollege($institution, $collegeName, 'None', 'None');
        $staff = new Staff;
        HierarchyService::populateStaff($request, $staff);

        $technicalStaff = new TechnicalStaff;
        $technicalStaff->staffRank = $request->input('technical_staff_rank');

        $college->technicalStaffs()->save($technicalStaff);
        $technicalStaff = TechnicalStaff::find($technicalStaff->id);
        $technicalStaff->general()->save($staff);

        return redirect('/staff/technical')->with('success', 'Successfully Added Technical Staff');
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
        $user->authorizeRoles('Department Admin');

        $data = array(
            'staff' => TechnicalStaff::with('general')->find($id),
            'page_name' => 'staff.technical.details'
        );
        return view('staff.technical.details')->with($data);
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
        $user->authorizeRoles('Department Admin');

        $data = array(
            'staff' => TechnicalStaff::with('general')->find($id),
            'page_name' => 'staff.technical.edit'
        );
        return view('staff.technical.edit')->with($data);
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
            'technical_staff_rank' => 'required',
        ]);
        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $technicalStaff = TechnicalStaff::find($id);
        $technicalStaff->staffRank = $request->input('technical_staff_rank');
        $technicalStaff->institution_id = null;

        $staff = $technicalStaff->general;
        HierarchyService::populateStaff($request, $staff);
        $technicalStaff->general()->save($staff);

        return redirect('/staff/technical')->with('primary', 'Successfully Updated');
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
        $item = TechnicalStaff::find($id);
        $item->delete();
        return redirect('/staff/technical')->with('primary', 'Successfully Deleted');
    }
}
