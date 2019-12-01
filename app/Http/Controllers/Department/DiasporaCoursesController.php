<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\DiasporaCourses;
use App\Models\Institution\Institution;
use App\Services\ApprovalService;
use App\Services\HierarchyService;
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
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $collegeDeps = $user->collegeName->departmentNames;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $courses = array();
        $total = 0;
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment)->get() as $department)
                    foreach ($department->diasporaCourses as $course){
                        $courses[] = $course;
                        $total += $course->male_number + $course->female_number;
                    }
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->diasporaCourses as $course){
                        $courses[] = $course;
                        $total += $course->male_number + $course->female_number;
                    }
        }

        $data = array(
            'courses' => $courses,
            'departments' => $collegeDeps,
            'total' => $total,

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
            'actions' => DiasporaCourses::getEnum('Actions'),
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
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;
        $educationLevel = request()->input('education_level', 'None');
        $educationProgram = request()->input('program', 'None');
        $yearLevel = request()->input('year_level', 'NONE');
        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, $educationLevel, $educationProgram, $yearLevel);

        $course = new DiasporaCourses;
        $course->action = $request->input('action');
        $course->male_number = $request->input('male_number');
        $course->female_number = $request->input('female_number');

        $course->department_id = $department->id;

        if ($course->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $course->save();

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
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        return redirect("/department/diaspora-courses");
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

        $diasporaCourse = DiasporaCourses::find($id);

        $data = array(
            'id' => $id,
            'male_number' => $diasporaCourse->male_number,
            'female_number' => $diasporaCourse->female_number,
            'action' => $diasporaCourse->action,
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
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'male_number' => 'required|numeric|between:0,10000000',
            'female_number' => 'required|numeric|between:0,10000000',
        ]);
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $diasporaCourses = DiasporaCourses::find($id);

        $diasporaCourses->male_number = $request->input('male_number');
        $diasporaCourses->female_number = $request->input('female_number');
        $diasporaCourse->approval_status = "Pending";

        $diasporaCourses->save();

        return redirect("/department/diaspora-courses")->with('primary', 'Successfully Updated');
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
        return redirect('/department/diaspora-courses')->with('primary', 'Successfully Deleted');
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);

        $action = $request->input('action');
        $selectedDepartment = $request->input('department');

        if ($action == "disapprove") {
            $course = DiasporaCourses::find($id);
            $course->approval_status = Institution::getEnum('ApprovalTypes')["DISAPPROVED"];
            $course->save();
        } else {
            $institution = $user->institution();

            foreach ($institution->colleges as $college) {
                if ($college->collegeName->college_name == $user->collegeName->college_name) {
                    foreach ($college->departments as $department) {
                        if ($department->departmentName->id == $selectedDepartment) {
                            ApprovalService::approveData($department->diasporaCourses);
                        }
                    }
                }
            }
        }
        return redirect("/department/diaspora-courses")->with('primary', 'Success');
    }
}
