<?php

namespace App\Http\Controllers;

use App\Models\College\CollegeName;
use App\Models\Department\DepartmentName;
use App\Models\College\Budget;
use App\Models\Department\UpgradingStaff;
use App\Models\Department\SpecialRegionEnrollment;
use App\Models\Department\DisadvantagedStudentEnrollment;
use App\Models\Department\SpecialProgramTeacher;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DisapprovedDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');

        $links = [];
        if($user->hasRole('Department Admin')){
            $links = self::getDepartmentDisapproved($user->departmentName);
        }else if($user->hasRole('College Admin')){
            $links = self::getCollegeDisapproved($user->collegeName);
        }

        $data = array(
            'links' => $links,
            'page_name' => 'data.disapproved.index',
        );

        return view('disapproved-data.index')->with($data);
    }

    function getDepartmentDisapproved(DepartmentName $departmentName){
        $links = array(
            "Student Enrollment" => [],
            "Special Region Students Enrollment" => [],
            "Students From Rural Areas Enrollment" => [],
            "Economically Disadvantaged Students Enrollment" => [],
            "Specializing Students" => [],
            "Students Coming From Regions Other than the Region that Hosts the Institution" => [],
            "Age Enrollment Data" => [],
            "Students Enrolled in Joint Programs with Foreign Universities" => [],
            "Student Attrition" => [],
            "Other Information" => [],
            "Exit Examination Information" => [],
            "Students Accessing Degree-relevant Employment Within 12 Months After Graduation" => [],
            "Qualified Internship" => [],
            "Teachers" => [],
            "Academic Staffs Upgrading Their Level of Education" => [],
            "Teachers on Special Program" => [],
            "Post Graduate Diploma Training" => [],
            "Ethiopian Diaspora Academics Taking Part in Teaching, Research and Academic Advising Activities" => [],
            "Research" => []
        );
        foreach($departmentName->department as $department){
            foreach($department->enrollments->where('approval_status', 'Disapproved') as $enrollment){
                $link = (String) url('enrollment/normal?student_type=' . $enrollment->student_type
                    . '&program=' . $enrollment->department->college->education_program . '&education_level=' 
                    . $enrollment->department->college->education_level);
                array_push($links["Student Enrollment"], $link);
            }

            foreach($department->specialRegionEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/special-region-students?region_type=' . $item->region_type
                    . '&student_type=' . SpecialRegionEnrollment::getValueKey(SpecialRegionEnrollment::getEnum('student_type'), $item->student_type)
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level
                    . '&year_level' . $item->department->year_level);
                array_push($links["Special Region Students Enrollment"], $link);
            }

            foreach($department->ruralStudentEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/rural-area-students?region=' . $item->region
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Students From Rural Areas Enrollment"], $link);
            }
            
            foreach($department->disadvantagedStudentEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/economically-disadvantaged?quintile=' . $item->quintile
                    . '&student_type=' . DisadvantagedStudentEnrollment::getValueKey(DisadvantagedStudentEnrollment::getEnum('student_type'), $item->student_type)
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Economically Disadvantaged Students Enrollment"], $link);
            }

            foreach($department->specializingStudentEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/specializing-students?student_type=' . $item->student_type
                    . '&program=' . $item->department->college->education_program 
                    . '&specialization_type=' . $item->specialization_type);
                array_push($links["Specializing Students"], $link);
            }

            foreach($department->otherRegionStudents->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/other-region-students?'
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Students Coming From Regions Other than the Region that Hosts the Institution"], $link);
            }

            foreach($department->ageEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/age-enrollment?'
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Age Enrollment Data"], $link);
            }

            foreach($department->jointProgramEnrollments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('enrollment/joint-program?'
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Students Enrolled in Joint Programs with Foreign Universities"], $link);
            }

            foreach($department->studentAttritions->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/student-attrition?student_type' . $item->student_type
                    . '&type=' . $item->type
                    . '&case=' . $item->case
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Student Attrition"], $link);
            }

            foreach($department->otherAttritions->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/other-attrition?'
                    . '&type=' . $item->type
                    . '&case=' . $item->case
                    . '&program=' . $item->department->college->education_program 
                    . '&education_level=' . $item->department->college->education_level);
                array_push($links["Other Information"], $link);
            }

            foreach($department->exitExaminations->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/exit-examination');
                array_push($links["Exit Examination Information"], $link);
            }

            foreach($department->degreeEmployments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/degree-relevant-employment');
                array_push($links["Students Accessing Degree-relevant Employment Within 12 Months After Graduation"], $link);
            }

            foreach($department->qualifiedInternships->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/qualified-internship');
                array_push($links["Qualified Internship"], $link);
            }

            foreach($department->teachers->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/teachers?education_level=' . $item->level_of_education);
                array_push($links["Teachers"], $link);
            }

            foreach($department->upgradingStaffs->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/upgrading-staff?study_place=' . UpgradingStaff::getValueKey(UpgradingStaff::getEnum('study_place'), $item->study_place));
                array_push($links["Academic Staffs Upgrading Their Level of Education"], $link);
            }

            foreach($department->specialProgramTeachers->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/special-program-teacher?program_status=' . SpecialProgramTeacher::getValueKey(SpecialProgramTeacher::getEnum('program_stat'), $item->program_stat));
                array_push($links["Teachers on Special Program"], $link);
            }

            foreach($department->postGraduateDiplomaTrainings->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/postgraduate-diploma-training?type=' . $item->is_lead = 0 ? "Teachers" : "School Leaders");
                array_push($links["Post Graduate Diploma Training"], $link);
            }

            foreach($department->diasporaCourses->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/diaspora-courses');
                array_push($links["Ethiopian Diaspora Academics Taking Part in Teaching, Research and Academic Advising Activities"], $link);
            }

            foreach($department->researches->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('department/researches?type=' . $item->type);
                array_push($links["Research"], $link);
            }
        }

        return $links;
    }

    function getCollegeDisapproved(CollegeName $collegeName){
        $links = array(
            "Budgets" => [],
            "Internal Revenues" => [],
            "Private Investments" => [],
            "University Industry Linkage" => []
        );

        foreach($collegeName->college as $college){
            foreach($college->budgets->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('budgets/budget?budget_type=' . Budget::getValueKey(Budget::getEnum('budget_type'), $item->budget_type));
                array_push($links["Budgets"], $link);
            }

            foreach($college->internalRevenues->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('budgets/internal-revenue');
                array_push($links["Internal Revenues"], $link);
            }

            foreach($college->investments->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('budgets/private-investment');
                array_push($links["Private Investments"], $link);
            }

            foreach($college->universityIndustryLinkages->where('approval_status', 'Disapproved') as $item){
                $link = (String) url('student/university-industry-linkage');
                array_push($links["University Industry Linkage"], $link);
            }

        }
        
        return $links;
    }
}
