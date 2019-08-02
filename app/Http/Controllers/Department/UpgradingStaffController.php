<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\UpgradingStaff;
use App\Models\Institution\Institution;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();

        $requestedPlace = $request->input('study_place');
        if ($requestedPlace == null) {
            $requestedPlace = 'ETHIOPIA';
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

//        $band=Band::where('band_name_id',$requestedBand)->first();
//        $college=College::where(['college_name_id'=>$requestedCollege,'band_id'=>$band->id])->first();
//        $departments=Department::where(['college_id'=>$college->id])->get();
        $filteredTeachers = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->UpgradingStaffs as $staff) {
                                            $filteredTeachers[] = $staff;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->UpgradingStaffs as $staff) {
                                            if (strtoupper($staff->study_place) == $requestedPlace) {
                                                $filteredTeachers[] = $staff;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }
        } else {
            $filteredTeachers = UpgradingStaff::with('department')->get();
        }


        //$specialProgramTeachers=SpecialProgramTeacher::all();
        //$specialProgramTeachers= SpecialProgramTeacher::where(['program_type'=>$requestedType,'program_status'=>$requestedStatus])->get();
        $data = [
            'study_place' => $requestedPlace,
            'upgrading_staffs' => $filteredTeachers,
            'departments' => DepartmentName::all(),

            'selected_department' => $requestedDepartment,
            'selected_place' => $requestedPlace,
            'page_name' => 'staff.upgrading-staff.index'
        ];
        //return $data['special_program_teachers'];
        //return $filteredTeachers;
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
            'bands' => BandName::all(),
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
            'male_number' => 'required',
            'female_number' => 'required'
        ]);


        $upgradingStaff = new UpgradingStaff();
        $upgradingStaff->male_number = $request->input('male_number');
        $upgradingStaff->female_number = $request->input('female_number');
        $upgradingStaff->education_level = $request->input('education_level');
        $upgradingStaff->study_place = $request->input('study_place');


        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
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
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'NONE';
            $college->education_program = 'NONE';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'NONE';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->upgradingStaffs()->save($upgradingStaff);

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

        $upgradingStaff = UpgradingStaff::find($id);

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
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $upgradingStaff = UpgradingStaff::find($id);

        $upgradingStaff->male_number = $request->input("male_number");
        $upgradingStaff->female_number = $request->input("female_number");

        $upgradingStaff->save();

        return redirect("/department/upgrading-staff");
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
        $item = UpgradingStaff::find($id);
        $item->delete();
        return redirect('/department/upgrading-staff');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $upgradingStaff = UpgradingStaff::find($id);
        if ($action == "approve") {
            $upgradingStaff->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $upgradingStaff->save();
        } elseif ($action == "disapprove") {
            $upgradingStaff->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $upgradingStaff->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->upgradingStaffs as $upgradingStaff) {
                                            if ($upgradingStaff->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                                $upgradingStaff->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $upgradingStaff->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return redirect("/department/upgrading-staff")->with('primary', 'Success');
    }
}
