<?php

namespace App\Http\Controllers;

use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\Enrollment;
use App\Models\Institution\AgeEnrollment;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\Institution;
use App\Models\Institution\SpecialNeeds;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $institutions = InstitutionName::all();
        $bands = BandName::all();
        $colleges = CollegeName::all();
        $departments = DepartmentName::all();

        $requestedType = $request->input('student_type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
        }

        $requestedSex = "all";
        if($request->has('male') && $request->has('female')){
            $requestedSex = "all";
        }elseif($request->has('male')){
            $requestedSex = "male";
        }elseif($request->has('female')){
            $requestedSex = "female";
        }

        $requestedInstitution = $request->input('institution');
        if ($requestedInstitution == null) {
            $requestedInstitution = InstitutionName::all()->first();
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = CollegeName::all()->first()->college_name;
        }

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = BandName::all()->first()->band_name;
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->department_name;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $data = array(
            "institutions_number" => $institutions->count(),
            "bands_number" => $bands->count(),
            "colleges_number" => $colleges->count(),
            "departments_number" => $departments->count(),

            'colleges' => CollegeName::all(),
            'bands' => BandName::all(),
            'programs' => College::getEnum("EducationPrograms"),
            'education_levels' => College::getEnum("EducationLevels"),
            'institutions' => InstitutionName::all(),
            'departments' => DepartmentName::all(),

            'selected_type' => $requestedType,
            'selected_sex' => $requestedSex,
            'selected_institution' => $requestedInstitution,
            'selected_band' => $requestedBand,
            'selected_college' => $requestedCollege,
            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,            
            'selected_education_level' => $requestedLevel,
            
           

            "page_name" => 'dashboard.dashboard.index',
        );
        return view('index')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

    public function enrollmentChart(Request $request)
    {
        $requestedType = $request->input('student_type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
        }

        $requestedSex = $request->input('sex');
        if ($requestedSex == null) {
            $requestedSex = 'all';
        }
        
        $requestedInstitution = $request->input('institution');
        if ($requestedInstitution == null) {
            $requestedInstitution = InstitutionName::all()->first();
            return $requestedInstitution;
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = CollegeName::all()->first()->college_name;
        }

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = BandName::all()->first()->band_name;
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->department_name;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 'Regular';
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 'Undergraduate';
        }

        $year_levels = array();
        foreach (Department::getEnum('YearLevels') as $key => $value) {
            $year_levels[] = $value;
        }
        array_pop($year_levels);

        $enrollments = array();

        foreach ($year_levels as $year) {
            $yearEnrollment = 0;
            foreach(Institution::all() as $institution){
                if($institution->institutionName == $requestedInstitution){
                    foreach ($institution->bands as $band) {
                        if ($band->bandName->band_name == $requestedBand) {
                            foreach ($band->colleges as $college) {
                                if ($college->collegeName->college_name == $requestedCollege && $college->education_level == $requestedLevel && $college->education_program == $requestedProgram) {
                                    foreach ($college->departments as $department) {
                                        if ($department->departmentName->department_name == $requestedDepartment && $department->year_level == $year) {
                                            foreach ($department->enrollments as $enrollment) {
                                                if ($enrollment->student_type == $requestedType) {
                                                    if($requestedSex == "male"){
                                                        $yearEnrollment += $enrollment->male_students_number;
                                                    }elseif($requestedSex == "female"){
                                                        $yearEnrollment += $enrollment->female_students_number;
                                                    }else{
                                                        $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
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
            }
            

            $enrollments[] = $yearEnrollment;

        }


        $result = array(
            "year_levels" => $year_levels,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }

    public function ageEnrollmentChart()
    {

        $ages = array();
        foreach (AgeEnrollment::getEnum('Ages') as $key => $value) {
            $ages[] = $value;
        }
        $enrollments = array();

        foreach (AgeEnrollment::all() as $enrollment) {
            $enrollments[] = $enrollment->male_students_number + $enrollment->female_students_number;
        }

        $result = array(
            "ages" => $ages,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }


}
