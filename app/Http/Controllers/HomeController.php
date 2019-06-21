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
use Illuminate\Contracts\Support\Renderable;
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
                "departments_number" => $departments->count(),
                "page_name" => 'dashboard.dashboard.index',
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
                "schools_number" => $generalInformation->schools,
                "page_name" => 'dashboard.dashboard.index',
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

            foreach($ages as $age){
                $ageEnrollment = 0;
                foreach($institution->bands as $band){
                    foreach($band->colleges as $college){
                        foreach($college->departments as $department){
                            foreach($department->ageEnrollments as $enrollment){
                                if($enrollment->age == $age){
                                    $ageEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                                }                                
                            }                        
                        }
                    }
                }
                $enrollments[] = $ageEnrollment;
            }
        }       

        $result = array(
            "ages" => $ages,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }

    public function specialNeedEnrollmentChart()
    {
        $disability_type = array();
        $disability_type_code = array();
        $number_of_male = array();
        $number_of_female = array();
        // $user = Auth::user();
        // $institution = $user->institution();

        foreach (SpecialNeeds::getEnum('NeedsTypes') as $key => $value) {
            $disability_type_code[] = $key;
            $disability_type[] = $value;
        }

        $total = SpecialNeeds::all();
        // die(var_dump($disability_type));
        foreach ($disability_type_code as $type) {
            foreach ($total as $info) {
                // die($info);
                // die($info->type == $type);
                if ($info->type == $type) {
                    // die(var_dump($info['male_students_number']));
                    $number_of_male[] = $info['male_students_number'];
                    // array_push($number_of_male , intval($info['male_student_number']));
                    // die(var_dump($number_of_male));
                    $number_of_female[] = $info['female_students_number'];
                }
            }
        }

        $result = array(
            'types' => $disability_type,
            'male' => $number_of_male,
            'female' => $number_of_female
        );
        return response()->json($result);
    }
}
