<?php

namespace App\Http\Controllers;

use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\InstitutionName;
use App\Models\Staff\Staff;
use Illuminate\Http\JsonResponse;
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

        $staffTypes = Staff::$staff_types;


        $institutions->prepend('Any');
        $bands->prepend('Any');
        $colleges->prepend('Any');
        $departments->prepend('Any');
        array_unshift($educationPrograms, 'Any');
        array_unshift($educationLevels, 'Any');
        array_unshift($staffTypes, 'Any');


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
            'staff_types' => $staffTypes,
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function enrollmentChart(Request $request)
    {

        $requestedType = $request->input('student_type');
        if ($requestedType == null) {
            $requestedType = 'Normal';
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


        $maleEnrollments = array();
        $femaleEnrollments = array();

        $cols = College::byCollegeNamesAndProgramsAndLevels(
            $selectedColleges, $selectedPrograms, $selectedLevels);
        $deps = Department::byCollegesAndDepartmentNames($cols, $selectedDepartment);
//        return $deps;


        foreach ($year_levels as $year) {
            $maleYearEnrollment = 0;
            $femaleYearEnrollment = 0;
            foreach ($deps as $department) {
                if ($department->year_level == $year) {
                    foreach ($department->enrollmentsApproved as $enrollment) {
                        if ($enrollment->student_type == $requestedType) {
                            $maleYearEnrollment += $enrollment->male_students_number;
                            $femaleYearEnrollment += $enrollment->female_students_number;
                        }
                    }
                }
            }
            $maleEnrollments[] = $maleYearEnrollment;
            $femaleEnrollments[] = $femaleYearEnrollment;
        }

        $cols = $colleges->map(function ($col) {
            return $col->__toString();
        });
        $deps = $departments->map(function ($dep) {
            return $dep->__toString();
        });

        $result = array(
            'colleges' => $cols,
            'departments' => $deps,

            "year_levels" => $year_levels,
            "male_enrollments" => $maleEnrollments,
            "female_enrollments" => $femaleEnrollments,
        );
        return response()->json($result);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function staffChart(Request $request)
    {
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

        $staffTypes = Staff::$staff_types;

        $cols = College::byCollegeNamesAndProgramsAndLevels(
            $selectedColleges, $selectedPrograms, $selectedLevels);
        $deps = Department::byCollegesAndDepartmentNames($cols, $selectedDepartment);
//        return $deps;

        $academicMales = 0;
        $academicFemales = 0;
        $administrativeMales = 0;
        $administrativeFemales = 0;
        $ictMales = 0;
        $ictFemales = 0;
        $supportiveMales = 0;
        $supportiveFemales = 0;
        $technicalsMales = 0;
        $technicalsFemales = 0;

        foreach ($deps as $dep) {
            $academicMales += $dep->academicStaffs()->where('sex', 'Male')->count();
            $academicFemales += $dep->academicStaffs()->where('sex', 'Female')->count();
        }
        foreach ($cols as $col) {
            $administrativeMales += $col->administrativeStaffs()->where('sex', 'Male')->count();
            $administrativeFemales += $col->administrativeStaffs()->where('sex', 'Female')->count();

            $ictMales += $col->ictStaffs()->where('sex', 'Male')->count();
            $ictFemales += $col->ictStaffs()->where('sex', 'Female')->count();

            $supportiveMales += $col->supportiveStaffs()->where('sex', 'Male')->count();
            $supportiveFemales += $col->supportiveStaffs()->where('sex', 'Female')->count();

            $technicalsMales += $col->technicalStaffs()->where('sex', 'Male')->count();
            $technicalsFemales += $col->technicalStaffs()->where('sex', 'Female')->count();
        }

        $maleStaffs = array(
            $academicMales,
            $administrativeMales,
            $ictMales,
            $supportiveMales,
            $technicalsMales,
        );
        $femaleStaffs = array(
            $academicFemales,
            $administrativeFemales,
            $ictFemales,
            $supportiveFemales,
            $technicalsFemales,
        );


        $cols = $colleges->map(function ($col) {
            return $col->__toString();
        });
        $deps = $departments->map(function ($dep) {
            return $dep->__toString();
        });

        $result = array(
            'colleges' => $cols,
            'departments' => $deps,

            "staff_types" => $staffTypes,
            "male_staffs" => $maleStaffs,
            "female_staffs" => $femaleStaffs,
        );
        return response()->json($result);
    }

}
