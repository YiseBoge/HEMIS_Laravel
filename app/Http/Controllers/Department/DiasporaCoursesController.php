<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\DepartmentName;
use App\Models\Department\DiasporaCourses;
use App\Models\Institution\Institution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DiasporaCoursesController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $institution = $user->institution();

        $requestedDepartment = $request->input('department');
        if ($requestedDepartment == null) {
            $requestedDepartment = DepartmentName::all()->first()->id;
        }

        $courses = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($user->hasRole('College Super Admin')) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $requestedDepartment) {
                                        foreach ($department->diasporaCourses as $course) {
                                            $courses[] = $course;
                                        }
                                    }
                                }
                            }
                        }else{
                            if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == 'None' && $college->education_program == 'None') {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->department_name == $user->departmentName->department_name) {
                                        foreach ($department->diasporaCourses as $course) {
                                            $courses[] = $course;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $courses = DiasporaCourses::with('department')->get();
        }

        //$enrollments=Enrollment::where('department_id',$department->id)->get();


        $data = array(
            'courses' => $courses,
            'departments' => DepartmentName::all(),

            'selected_department' => $requestedDepartment,

            'page_name' => 'staff.diaspora_course.index'
        );
        //return $filteredEnrollments;
        return view("departments.diaspora_course.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $data = array(
            'page_name' => 'staff.diaspora_course.create'
        );
        //return $filteredEnrollments;
        return view("departments.diaspora_course.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_number' => 'required',
            'research_number' => 'required'
        ]);

        $course = new DiasporaCourses;
        $course->number_of_courses = $request->input('course_number');
        $course->number_of_researches = $request->input('research_number');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = 0;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => 'None', 'education_program' => 'None'])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = 'None';
            $college->education_program = 'None';
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => 'None',
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = 'None';
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->diasporaCourses()->save($course);

        return redirect("/department/diaspora-courses")->with('success', 'Successfully Added Diaspora Course');

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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $diasporaCourses = DiasporaCourses::find($id);

        $data = array(
            'id' => $id,
            'number_of_courses' => $diasporaCourses->number_of_courses,
            'number_of_researches' => $diasporaCourses->number_of_researches,
            'page_name' => 'staff.diaspora_course.edit'
        );
        return view("departments.diaspora_course.edit")->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $diasporaCourses = DiasporaCourses::find($id);

        $diasporaCourses->number_of_courses = $request->input('number_of_courses');
        $diasporaCourses->number_of_researches = $request->input('number_of_researches');

        $diasporaCourses->save();

        return redirect("/department/diaspora-courses");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $item = DiasporaCourses::find($id);
        $item->delete();
        return redirect('/department/diaspora-courses');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        $course = DiasporaCourses::find($id);
        if ($action == "approve") {
            $course->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
            $course->save();
        } elseif ($action == "disapprove") {
            $course->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $course->save();
        } else {
            $institution = $user->institution();

            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if ($band->bandName->band_name == $user->bandName->band_name) {
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if ($department->departmentName->id == $selectedDepartment) {
                                        foreach ($department->diasporaCourses as $course) {
                                            if ($enrollment->approval_status == Institution::getEnum('ApprovalTypes')["PENDING"]) {
                                                $course->approval_status = Institution::getEnum('ApprovalTypes')["APPROVED"];
                                                $course->save();
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
        return redirect("/department/diaspora-courses")->with('primary', 'Success');
    }
}
