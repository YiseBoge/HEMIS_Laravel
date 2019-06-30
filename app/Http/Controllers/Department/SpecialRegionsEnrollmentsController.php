<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\SpecialRegionEnrollment;
use App\Models\Institution\RegionName;
use App\Models\Institution\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SpecialRegionsEnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedYearLevel = $request->input('year_level');
        if ($requestedYearLevel == null) {
            $requestedYearLevel = '1';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $requestedType = $request->input('region_type');
        if ($requestedType == null) {
            $requestedType = 'Emerging Regions';
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $enrollments = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                            foreach ($college->departments as $department) {
                                if ($user->hasRole('College Super Admin')) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->specialRegionEnrollments as $enrollment) {
                                            if($enrollment->region_type == $requestedType){
                                                $enrollments[] = $enrollment;
                                            }
                                        }
                                    }
                                } else {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->specialRegionEnrollments as $enrollment) {
                                            if($enrollment->region_type == $requestedType){
                                                $enrollments[] = $enrollment;
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
            $enrollments = SpecialRegionEnrollment::all();
        }

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum("YearLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);


        $data = array(
            'enrollments' => $enrollments,
            'types' => SpecialRegionEnrollment::getEnum("RegionTypes"),
            'departments' => DepartmentName::all(),
            'regions' => RegionName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,

            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_year' => $requestedYearLevel,
            'selected_education_level' => $requestedLevel,
            'selected_type' => $requestedType,
            'page_name' => 'enrollment.special_region_students.index'
        );
        return view("enrollment.special_region_students.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $year_levels = Department::getEnum("YearLevels");
        array_pop($educationPrograms);
        array_pop($educationLevels);
        array_pop($year_levels);

        $data = array(
            'types' => SpecialRegionEnrollment::getEnum("RegionTypes"),
            'regions' => RegionName::all(),
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'year_levels' => $year_levels,
            'page_name' => 'enrollment.special_region_students.create'
        );
        return view('enrollment.special_region_students.create')->with($data);
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

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $enrollment = new SpecialRegionEnrollment;       

        $enrollment->male_number = $request->input('male_number');
        $enrollment->female_number = $request->input('female_number');
        $enrollment->region_type = $request->input('region_type');
        $enrollment->region_name_id = 0;

        $regionName = RegionName::where('name', $request->input("region"))->first();

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
            'education_level' => $request->input("education_level"), 'education_program' => $request->input("program")])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = $request->input("education_level");
            $college->education_program = $request->input("program");
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => $request->input("year_level"),
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = $request->input("year_level");
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->specialRegionEnrollments()->save($enrollment);
        $regionName->specialRegionEnrollment()->save($enrollment);

        return redirect("/enrollment/special-region-students");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');
        
        $enrollment = SpecialRegionEnrollment::find($id);
        if ($action == "approve") {
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $enrollment->save();
        } elseif ($action == "disapprove") {
            $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $enrollment->save();
        } else {

            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->specialRegionEnrollments as $enrollment) {
                                            if($enrollment->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]){
                                                $enrollment->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $enrollment->save();
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

            }
        }
        return redirect("/enrollment/special-region-students?department=" . $selectedDepartment);
    }
}
