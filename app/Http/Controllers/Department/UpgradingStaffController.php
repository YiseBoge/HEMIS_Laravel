<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\Department\UpgradingStaff;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpgradingStaffController extends Controller
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
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);
        $selectedPlace = UpgradingStaff::getEnum('study_place')[$requestedPlace = request()->query('study_place', 'ETHIOPIA')];

        $filteredTeachers = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->upgradingStaffs as $teacher){
                        $filteredTeachers[] = $teacher;
                        $total += $teacher->male_number + $teacher->female_number;
                    }
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->upgradingStaffs()->where('study_place', $selectedPlace)->get() as $teacher){
                        $filteredTeachers[] = $teacher;
                        $total += $teacher->male_number + $teacher->female_number;
                    }
        }

        $data = [
            'study_place' => $requestedPlace,
            'upgrading_staffs' => $filteredTeachers,
            'departments' => $collegeDeps,
            'total' => $total,

            'selected_department' => $requestedDepartment,
            'selected_place' => $requestedPlace,
            'page_name' => 'staff.upgrading-staff.index'
        ];
        
        return view('departments.upgrading_staff.index')->with($data);

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

        $data = [
            'education_level' => UpgradingStaff::getEnum("EducationLevels"),
            'study_place' => UpgradingStaff::getEnum("StudyPlaces"),
            'colleges' => CollegeName::all(),
            'departments' => DepartmentName::all(),
            'page_name' => 'staff.upgrading-staff.create'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
        return view('departments.upgrading_staff.create')->with($data);
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
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'NONE');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $upgradingStaff = new UpgradingStaff();
        $upgradingStaff->male_number = $request->input('male_number');
        $upgradingStaff->female_number = $request->input('female_number');
        $upgradingStaff->education_level = $request->input('level');
        $upgradingStaff->study_place = $request->input('study_place');

        $upgradingStaff->department_id = $department->id;

        if ($upgradingStaff->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $upgradingStaff->save();

        return redirect("/department/upgrading-staff")->with('success', 'Successfully Added Upgrading Staff');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect("/department/upgrading-staff");
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $upgradingStaff = UpgradingStaff::findOrFail($id);

        $data = [
            'id' => $id,
            'education_level' => $upgradingStaff->education_level,
            'study_place' => $upgradingStaff->study_place,
            'male_number' => $upgradingStaff->male_number,
            'female_number' => $upgradingStaff->female_number,
            'page_name' => 'staff.upgrading-staff.edit'
        ];

        return view('departments.upgrading_staff.edit')->with($data);
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
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $upgradingStaff = UpgradingStaff::findOrFail($id);

        $upgradingStaff->male_number = $request->input("male_number");
        $upgradingStaff->female_number = $request->input("female_number");
        $upgradingStaff->approval_status = "Pending";

        $upgradingStaff->save();

        return redirect("/department/upgrading-staff")->with('primary', 'Successfully Updated');
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
        $item = UpgradingStaff::findOrFail($id);
        $item->delete();
        return redirect('/department/upgrading-staff')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $upgradingStaff = UpgradingStaff::findOrFail($id);
            $upgradingStaff->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $upgradingStaff->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->upgradingStaffs);
                        }
                    }
                }
            }
        }
        return redirect("/department/upgrading-staff")->with('primary', 'Success');
    }
}
