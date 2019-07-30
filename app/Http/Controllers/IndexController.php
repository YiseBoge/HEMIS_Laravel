<?php

namespace App\Http\Controllers;

use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\InstitutionName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $disabled = array();

        $requestedType = $request->input('student_type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
        }

        $requestedSex = "all";
        if ($request->has('male') && $request->has('female')) {
            $requestedSex = "all";
        } elseif ($request->has('male')) {
            $requestedSex = "male";
        } elseif ($request->has('female')) {
            $requestedSex = "female";
        }

        $requestedInstitution = $request->input('institution');
        if ($requestedInstitution == null) {
            $requestedInstitution = 0;
        }

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = 0;
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = 0;
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = 0;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 0;
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 0;
        }


        $institutions = InstitutionName::all();
        if ($requestedInstitution == 0) {
            $selectedInstitutions = $institutions;
            $requestedBand = 0;
            $requestedCollege = 0;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
            array_push($disabled, 'band');
        } else {
            $selectedInstitutions = collect()->add($institutions[$requestedInstitution - 1]);
        }


        $bands = BandName::all();
        if ($requestedBand == 0) {
            $selectedBands = $bands;
            $requestedCollege = 0;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
            array_push($disabled, 'college');
        } else {
            $selectedBands = collect()->add($bands[$requestedBand - 1]);
        }


        $colleges = CollegeName::byInstitutionNamesAndBandNames($selectedInstitutions, $selectedBands);
//        return $colleges;
        if ($requestedCollege == 0) {
            $selectedColleges = $colleges;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
            array_push($disabled, 'department', 'program', 'level');
        } else {
            $selectedColleges = collect()->add($colleges[$requestedCollege - 1]);
        }


        $departments = DepartmentName::byCollegeNames($selectedColleges);
//        return $departments;
        if ($requestedDepartment == 0) {
            $selectedDepartment = $departments;
        } else {
            $selectedDepartment = collect()->add($departments[$requestedDepartment - 1]);
        }


        $educationPrograms = College::getEnum("EducationPrograms");
//        return $educationPrograms;
        if ($requestedProgram == 0) {
            $selectedPrograms = $educationPrograms;
        } else {
            $selectedPrograms = collect()->add($educationPrograms[$requestedProgram - 1]);
        }


        $educationLevels = College::getEnum("EducationLevels");
//        return $educationLevels;
        if ($requestedLevel == 0) {
            $selectedLevels = $educationLevels;
        } else {
            $selectedLevels = collect()->add($educationLevels[$requestedLevel - 1]);
        }


        $institutions->prepend('Any');
        $bands->prepend('Any');
        $colleges->prepend('Any');
        $departments->prepend('Any');
        array_unshift($educationPrograms, 'Any');
        array_unshift($educationLevels, 'Any');


//        return $disabled;
        $data = array(
            "institutions_number" => $institutions->count(),
            "bands_number" => $bands->count(),
            "colleges_number" => $colleges->count(),
            "departments_number" => $departments->count(),

            'colleges' => $colleges,
            'bands' => $bands,
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'institutions' => $institutions,
            'departments' => $departments,

            'selected_type' => $requestedType,
            'selected_sex' => $requestedSex,
            'selected_institution' => $requestedInstitution,
            'selected_band' => $requestedBand,
            'selected_college' => $requestedCollege,
            'selected_department' => $requestedDepartment,
            'selected_program' => $requestedProgram,
            'selected_education_level' => $requestedLevel,

            "disabled" => $disabled,
            "page_name" => 'welcome.welcome.index',
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
            $requestedInstitution = 0;
        }

        $requestedBand = $request->input('band');
        if ($requestedBand == null) {
            $requestedBand = 0;
        }

        $requestedCollege = $request->input('college');
        if ($requestedCollege == null) {
            $requestedCollege = 0;
        }

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = 0;
        }

        $requestedProgram = $request->input('program');
        if ($requestedProgram == null) {
            $requestedProgram = 0;
        }

        $requestedLevel = $request->input('education_level');
        if ($requestedLevel == null) {
            $requestedLevel = 0;
        }

        $year_levels = array();
        foreach (Department::getEnum('YearLevels') as $key => $value) {
            $year_levels[] = $value;
        }
        array_pop($year_levels);


        $institutions = InstitutionName::all();
        if ($requestedInstitution == 0) {
            $selectedInstitutions = $institutions;
            $requestedBand = 0;
            $requestedCollege = 0;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
        } else {
            $selectedInstitutions = collect()->add($institutions[$requestedInstitution - 1]);
        }


        $bands = BandName::all();
        if ($requestedBand == 0) {
            $selectedBands = $bands;
            $requestedCollege = 0;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
        } else {
            $selectedBands = collect()->add($bands[$requestedBand - 1]);
        }


        $colleges = CollegeName::byInstitutionNamesAndBandNames($selectedInstitutions, $selectedBands);
//        return $colleges;
        if ($requestedCollege == 0) {
            $selectedColleges = $colleges;
            $requestedDepartment = 0;
            $requestedProgram = 0;
            $requestedLevel = 0;
        } else {
            $selectedColleges = collect()->add($colleges[$requestedCollege - 1]);
        }


        $departments = DepartmentName::byCollegeNames($selectedColleges);
//        return $departments;
        if ($requestedDepartment == 0) {
            $selectedDepartment = $departments;
        } else {
            $selectedDepartment = collect()->add($departments[$requestedDepartment - 1]);
        }


        $educationPrograms = College::getEnum("EducationPrograms");
//        return $educationPrograms;
        if ($requestedProgram == '0') {
            $selectedPrograms = $educationPrograms;
        } else {
            $selectedPrograms = array($requestedProgram, $educationPrograms[$requestedProgram]);
        }


        $educationLevels = College::getEnum("EducationLevels");
//        return $educationLevels;
        if ($requestedLevel == '0') {
            $selectedLevels = $educationLevels;
        } else {
            $selectedLevels = array($requestedLevel, $educationLevels[$requestedLevel]);
        }


        $enrollments = array();

        $cols = College::byCollegeNamesAndProgramsAndLevels(
            $selectedColleges, $selectedPrograms, $selectedLevels);
        $deps = Department::byCollegesAndDepartmentNames($cols, $selectedDepartment);
//        return $deps;

        foreach ($year_levels as $year) {
            $yearEnrollment = 0;
            foreach ($deps as $department) {
                if ($department->year_level == $year) {
                    foreach ($department->enrollmentsApproved as $enrollment) {
                        if ($enrollment->student_type == $requestedType) {
                            if ($requestedSex == "male") {
                                $yearEnrollment += $enrollment->male_students_number;
                            } elseif ($requestedSex == "female") {
                                $yearEnrollment += $enrollment->female_students_number;
                            } else {
                                $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
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

}
