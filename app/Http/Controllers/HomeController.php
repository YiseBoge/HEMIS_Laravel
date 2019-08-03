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
        } else {
            $institution = $user->institution();
            $generalInformation = $institution->generalInformation;
            $colleges = 0;
            foreach ($institution->bands as $band) {
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
                foreach (Enrollment::all() as $enrollment) {
                    if ($enrollment->department->year_level == $year) {
                        $yearEnrollment += ($enrollment->male_students_number + $enrollment->female_students_number);
                    }
                }
                $enrollments[] = $yearEnrollment;

            }

        } else {
            $user = Auth::user();
            $institution = $user->institution();

            foreach ($year_levels as $year) {
                $yearEnrollment = 0;
                foreach ($institution->bands as $band) {
                    foreach ($band->colleges as $college) {
                        foreach ($college->departments as $department) {
                            if ($department->year_level == $year) {
                                foreach ($department->enrollmentsApproved as $enrollment) {
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

    public function ageEnrollmentChart()
    {

        $ages = array();
        foreach (AgeEnrollment::getEnum('Ages') as $key => $value) {
            $ages[] = $value;
        }
        $enrollments = array();

        if (Auth::user()->hasRole('Super Admin')) {
            foreach (AgeEnrollment::all() as $enrollment) {
                $enrollments[] = $enrollment->male_students_number + $enrollment->female_students_number;
            }
        } else {
            $user = Auth::user();
            $institution = $user->institution();

            foreach ($ages as $age) {
                $ageEnrollment = 0;
                foreach ($institution->bands as $band) {
                    foreach ($band->colleges as $college) {
                        foreach ($college->departments as $department) {
                            foreach ($department->ageEnrollments as $enrollment) {
                                if ($enrollment->age == $age) {
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
}
