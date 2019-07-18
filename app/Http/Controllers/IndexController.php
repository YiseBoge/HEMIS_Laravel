<?php

namespace App\Http\Controllers;
use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\Enrollment;
use App\Models\Institution\AgeEnrollment;
use App\Models\Institution\InstitutionName;
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
    public function index()
    {    
        $institutions = InstitutionName::all();
        $bands = BandName::all();
        $colleges = CollegeName::all();
        $departments = DepartmentName::all();

        $data = array(
            "institutions_number" => $institutions->count(),
            "bands_number" => $bands->count(),
            "colleges_number" => $colleges->count(),
            "departments_number" => $departments->count(),
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
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function enrollmentChart()
    {
        $year_levels = array();
        foreach (Department::getEnum('YearLevels') as $key => $value) {
            $year_levels[] = $value;
        }
        array_pop($year_levels);
        $enrollments = array();

        
        foreach ($year_levels as $year) {
            $yearEnrollment = 0;
            foreach (Enrollment::all() as $enrollment) {
                if ($enrollment->department->year_level == $year) {
                    $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
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
