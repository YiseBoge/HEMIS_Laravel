<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\JobTitle;
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

        $technicalStaffs = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                foreach ($department->technicalStaffs as $technicalStaff)
                    $technicalStaffs[] = $technicalStaff;
        }

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

        $academicStaffs = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                foreach ($department->academicStaffs as $academicStaff)
                    if (!$department->technicalStaffs->pluck('staff_id')->contains($academicStaff->general->id))
                        $academicStaffs[] = $academicStaff;
        }

        $data = array(
            'staffs' => $academicStaffs,
            'employment_types' => Staff::getEnum("employment_type"),
            'dedications' => Staff::getEnum("dedication"),
            'academic_levels' => Staff::getEnum("academic_levels"),
            'staff_ranks' => TechnicalStaff::getEnum("staff_rank"),
//            'job_titles' => JobTitle::where('staff_type', 'Technical')->get(),
            'job_titles' => JobTitle::where('staff_type', 'Administrative')->get(),
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
            'job_title' => 'required',
            'staff' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();
        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;

        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, "None", "None", "NONE");
        $academicStaff = AcademicStaff::find($request->input('staff'));
        $staff = $academicStaff->general;

        $technicalStaff = new TechnicalStaff;
        $technicalStaff->job_title_id = $request->input('job_title');
        $technicalStaff->staff_id = $staff->id;

        $department->technicalStaffs()->save($technicalStaff);
        

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
//            'job_titles' => JobTitle::where('staff_type', 'Technical')->get(),
            'job_titles' => JobTitle::where('staff_type', 'Administrative')->get(),
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
            'job_title' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('College Admin');

        $technicalStaff = TechnicalStaff::findOrFail($id);
        $technicalStaff->job_title_id = $request->input('job_title');
        $technicalStaff->save();

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
        $item = TechnicalStaff::findOrFail($id);
        $item->delete();
        return redirect('/staff/technical')->with('primary', 'Successfully Deleted');
    }
}
