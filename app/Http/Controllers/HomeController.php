<?php

namespace App\Http\Controllers;

use App\Models\Band\BandName;
use App\Models\College\CollegeName;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\Enrollment;
use App\Models\Institution\AgeEnrollment;
use App\Models\Institution\InstitutionName;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $user = Auth::user();
        if ($user == null) return redirect('/login');

        if ($user->hasRole('Super Admin')) {
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
            return view('home')->with($data);
        } else if ($user->hasRole('University Admin')) {
            $institution = $user->institution();
            $generalInformation = $institution->generalInformation;
            $institutionName = $user->institutionName;

            $data = array(
                "name" => $institution->institutionName->institution_name,
                "titles" => ["Number of Campuses", "Number of Colleges", "Number of Institutes", "Number of Schools"],
                "data" => [$generalInformation->campuses, $institutionName->collegeNames->count(),
                    $generalInformation->institutes, $generalInformation->schools],
                "page_name" => 'dashboard.dashboard.index',
            );

            return view('home')->with($data);
        } else if ($user->hasRole('College Super Admin') || $user->hasRole('College Admin')) {
            $collegeName = $user->collegeName;
            $students_number = 0;
            $staff_number = 0;
            $teachers_number = 0;
            foreach ($collegeName->college as $college) {
                foreach ($college->departments as $department) {
                    foreach ($department->enrollmentsApproved as $enrollment) {
                        $students_number += $enrollment->male_students_number + $enrollment->female_students_number;
                    }
                    foreach ($department->teachersApproved as $teacher) {
                        $teachers_number += $teacher->male_number + $teacher->female_number;
                    }
                    $staff_number += $department->academicStaffs->count();
                }
                $staff_number += $college->administrativeStaffs->count();
                $staff_number += $college->ictStaffs->count();
                $staff_number += $college->managementStaffs->count();
                $staff_number += $college->technicalStaffs->count();
            }

            $data = array(
                "name" => $collegeName,
                "titles" => ["Number of Departments", "NUmber of Students",
                    "Number of staff", "Number of Teachers"],
                "data" => [$collegeName->departmentNames->count(), $students_number,
                    $staff_number, $teachers_number],
                "page_name" => 'dashboard.dashboard.index',
            );

            return view('home')->with($data);
        } else {
            $institution = $user->institution();
            $departmentName = $user->departmentName;
            $students_number = 0;
            $staff_number = 0;
            $teachers_number = 0;
            $researches_number = 0;
            foreach ($departmentName->department as $department) {
                foreach ($department->enrollmentsApproved as $enrollment) {
                    $students_number += $enrollment->male_students_number + $enrollment->female_students_number;
                }
                foreach ($department->teachersApproved as $teacher) {
                    $teachers_number += $teacher->male_number + $teacher->female_number;
                }
                foreach ($department->researchesApproved as $research) {
                    $researches_number += $research->number;
                }
                $staff_number += $department->academicStaffs->count();
            }

            $data = array(
                "name" => $departmentName,
                "titles" => ["Number of Students", "Number of staff",
                    "Number of Teachers", "Number of Researches"],
                "data" => [$students_number, $staff_number, $teachers_number, $researches_number],
                "page_name" => 'dashboard.dashboard.index',
            );

            return view('home')->with($data);
        }
    }

    /**
     * @return Response
     */
    public function showChangePasswordForm()
    {
        $data = array(
            'page_name' => 'user.change_password.index'
        );
        return view('auth.passwords.change_password');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect("/home")->with("success", "Successfully Changed Password");
    }

    /**
     * @return JsonResponse
     */
    public function enrollmentChart()
    {
        $year_levels = array();
        foreach (Department::getEnum('YearLevels') as $key => $value) {
            $year_levels[] = $value;
        }
        array_pop($year_levels);
        $enrollments = array();

        if (Auth::user() == null || Auth::user()->hasRole('Super Admin')) {
            foreach ($year_levels as $year) {
                $yearEnrollment = 0;
                foreach (Enrollment::where('approval_status', 'Approved') as $enrollment)
                    if ($enrollment->department->year_level == $year)
                        $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                $enrollments[] = $yearEnrollment;
            }

        } else if (Auth::user()->hasRole('University Admin')) {
            $user = Auth::user();
            $institution = $user->institution();

            foreach ($year_levels as $year) {
                $yearEnrollment = 0;
                foreach ($institution->colleges as $college)
                    foreach ($college->departments as $department)
                        if ($department->year_level == $year)
                            foreach ($department->enrollmentsApproved as $enrollment)
                                $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);

                $enrollments[] = $yearEnrollment;
            }
        } else if (Auth::user()->hasRole('College Super Admin') || Auth::user()->hasRole('College Admin')) {
            $user = Auth::user();
            $collegeName = $user->collegeName;

            foreach ($year_levels as $year) {
                $yearEnrollment = 0;
                foreach ($collegeName->college as $college)
                    foreach ($college->departments as $department)
                        if ($department->year_level == $year)
                            foreach ($department->enrollmentsApproved as $enrollment)
                                $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);

                $enrollments[] = $yearEnrollment;
            }
        } else {
            $user = Auth::user();
            $departmentName = $user->departmentName;

            foreach ($year_levels as $year) {
                $yearEnrollment = 0;
                foreach ($departmentName->department as $department)
                    if ($department->year_level == $year)
                        foreach ($department->enrollmentsApproved as $enrollment)
                            $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);

                $enrollments[] = $yearEnrollment;
            }
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

        if (Auth::user()->hasRole('Super Admin')) {
            foreach (AgeEnrollment::where('approval_status', 'Approved') as $enrollment)
                $enrollments[] = $enrollment->male_students_number + $enrollment->female_students_number;

        } else if (Auth::user()->hasRole('College Super Admin') || Auth::user()->hasRole('College Admin')) {
            $user = Auth::user();
            $collegeName = $user->collegeName;

            foreach ($ages as $age) {
                $ageEnrollment = 0;
                foreach ($collegeName->college as $college)
                    foreach ($college->departments as $department)
                        foreach ($department->ageEnrollmentsApproved as $enrollment)
                            if ($enrollment->age == $age)
                                $ageEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);

                $enrollments[] = $ageEnrollment;
            }
        } else {
            $user = Auth::user();
            $departmentName = $user->departmentName;

            foreach ($ages as $age) {
                $ageEnrollment = 0;
                foreach ($departmentName->department as $department)
                    foreach ($department->ageEnrollmentsApproved as $enrollment)
                        if ($enrollment->age == $age)
                            $ageEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);

                $enrollments[] = $ageEnrollment;
            }
        }

        $result = array(
            "ages" => $ages,
            "enrollments" => $enrollments
        );
        return response()->json($result);
    }
}
