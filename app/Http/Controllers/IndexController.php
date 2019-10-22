<?php

namespace App\Http\Controllers;

use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\AgeEnrollment;
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
     * @return Response
     */
    public function index()
    {
        $institutions = InstitutionName::all();
        $bands = BandName::all();
        $educationPrograms = College::getEnum("EducationPrograms");
        $educationLevels = College::getEnum("EducationLevels");
        $staffTypes = Staff::$staff_types;

//        $reporter = new GeneralReportService(Auth::user()->currentInstance->year);
//        $studentsNumber = $reporter->enrollment('All', College::getEnum('education_level')['UNDERGRADUATE']) +
//            $reporter->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
//            $reporter->enrollment('All', College::getEnum('education_level')['POST_GRADUATE_PHD']);

        $institutions->prepend('Any');
        $bands->prepend('Any');
        array_unshift($educationPrograms, 'Any');
        array_unshift($educationLevels, 'Any');
        array_unshift($staffTypes, 'Any');

        $data = array(
//            'students_number' => $studentsNumber,

            'bands' => $bands,
            'programs' => $educationPrograms,
            'education_levels' => $educationLevels,
            'staff_types' => $staffTypes,
            'institutions' => $institutions,

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


        $year_levels = array_values(Department::getEnum('YearLevels'));
        array_pop($year_levels);

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

        $year_levels = collect($year_levels)->map(function ($lev) {
            if (!in_array(((int)$lev % 100), array(11, 12, 13))) {
                switch ((int)$lev % 10) {
                    case 1:
                        return $lev . 'st';
                    case 2:
                        return $lev . 'nd';
                    case 3:
                        return $lev . 'rd';
                }
            }
            return $lev . 'th';
        });
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
        $technicalMales = 0;
        $technicalFemales = 0;

        foreach ($deps as $dep) {
            foreach ($dep->academicStaffs as $staff) {
                if ($staff->general->sex == 'Male') $academicMales++;
                if ($staff->general->sex == 'Female') $academicFemales++;
            }
        }
        foreach ($cols as $col) {
            foreach ($col->administrativeStaffs as $staff) {
                if ($staff->general->sex == 'Male') $administrativeMales++;
                if ($staff->general->sex == 'Female') $administrativeFemales++;
            }
            foreach ($col->ictStaffs as $staff) {
                if ($staff->general->sex == 'Male') $ictMales++;
                if ($staff->general->sex == 'Female') $ictFemales++;
            }
            foreach ($col->technicalStaffs as $staff) {
                if ($staff->general->sex == 'Male') $technicalMales++;
                if ($staff->general->sex == 'Female') $technicalFemales++;
            }
        }

        $maleStaffs = array(
            $academicMales,
            $administrativeMales,
            $ictMales,
            $technicalMales,
        );
        $femaleStaffs = array(
            $academicFemales,
            $administrativeFemales,
            $ictFemales,
            $technicalFemales,
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


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ageEnrollmentChart(Request $request)
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

        $ageRanges = array_values(AgeEnrollment::getEnum('age'));

        $maleEnrollments = array();
        $femaleEnrollments = array();

        $cols = College::byCollegeNamesAndProgramsAndLevels(
            $selectedColleges, $selectedPrograms, $selectedLevels);
        $deps = Department::byCollegesAndDepartmentNames($cols, $selectedDepartment);
//        return $deps;


        foreach ($ageRanges as $ageRange) {
            $maleYearEnrollment = 0;
            $femaleYearEnrollment = 0;
            foreach ($deps as $department) {
                foreach ($department->ageEnrollmentsApproved as $enrollment) {
                    if ($enrollment->age == $ageRange) {
                        $maleYearEnrollment += $enrollment->male_students_number;
                        $femaleYearEnrollment += $enrollment->female_students_number;
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

            "age_ranges" => $ageRanges,
            "male_enrollments" => $maleEnrollments,
            "female_enrollments" => $femaleEnrollments,
        );
        return response()->json($result);
    }

}
