<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Band\Band;
use App\Models\Band\BandName;
use App\Models\College\College;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\GeneralInformation;
use App\Models\Department\Enrollment;
use App\Models\Institution\AgeEnrollment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->hasRole('Super Admin')){  
            $institutions = InstitutionName::get();
            $bands = BandName::get();
            $colleges = CollegeName::get();
            $departments = DepartmentName::get();

            $data = array(
                "institutions_number" => $institutions->count(),
                "bands_number" => $bands->count(),
                "colleges_number" => $colleges->count(),
                "departments_number" => $departments->count()
            );
            return view('home')->with($data);
        }else{
            $user = Auth::user();
            $institution = $user->institution();
            $generalInformation = $institution->generalInformation;
            $colleges = 0;
            foreach($institution->bands as $band){
                $colleges += $band->colleges->count();
            } 
    
            $data = array(
                "name" => $institution->institutionName->institution_name,
                "campuses_number" => $generalInformation->campuses,
                "colleges_number" => $colleges,
                "institutes_number" => $generalInformation->institutes,
                "schools_number" => $generalInformation->schools
            );

            return view('home')->with($data);
        }
       
    }

    public function enrollmentChart()
    {
        $year_levels = array();
        foreach(Department::getEnum('YearLevels') as $key => $value){
            $year_levels[] = $value;
        }
        array_pop($year_levels);
        $enrollments = array();

        if (Auth::user()->hasRole('Super Admin')){
            foreach($year_levels as $year){
                $yearEnrollment = 0;
                foreach(Enrollment::get() as $enrollment){
                    if($enrollment->department->year_level == $year){
                        $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                    }                    
                }
                $enrollments[] = $yearEnrollment;
                
            }
           
        }else{
            $user = Auth::user();
            $institution = $user->institution();

            foreach($year_levels as $year){
                $yearEnrollment = 0;
                foreach($institution->bands as $band){
                    foreach($band->colleges as $college){
                        foreach($college->departments as $department){
                            if($department->year_level == $year){
                                foreach($department->enrollments as $enrollment){
                                    $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                                }
                            }
                        }
                    }
                }
                $enrollments[] = $yearEnrollment;
            }
        }

        $result = array(
            "year_levels" => $year_levels,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }

    public function ageEnrollmentChart(){

        $ages = array();
        foreach(AgeEnrollment::getEnum('Ages') as $key => $value){
            $ages[] = $value;
        }
        $enrollments = array();

        if (Auth::user()->hasRole('Super Admin')){
            foreach(AgeEnrollment::all() as $enrollment){
                $enrollments[] = $enrollment->male_students_number + $enrollment->female_students_number;
            }
        }else{
            $user = Auth::user();
            $institution = $user->institution();

            foreach($institution->ageEnrollment as $enrollment){
                $enrollments[] = $enrollment->male_students_number + $enrollment->female_students_number;
            }
        }       

        $result = array(
            "ages" => $ages,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }

    
}
