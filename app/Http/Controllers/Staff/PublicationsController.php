<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\PublicationsAndPatents;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\StaffPublication;
use App\Services\HierarchyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PublicationsController extends Controller
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
        $institution = $user->institution();
        $collegeDeps = $user->collegeName->departmentNames;

        $collegeName = $user->collegeName;
        $departmentName = $user->departmentName;

        $requestedDepartment = request()->query('department', $collegeDeps->first()->id);

        $publications = array();
        /** @var College $college */
        foreach ($user->collegeName->college as $college) {
            if ($user->hasRole('College Super Admin')) {
                foreach ($college->departments()->where('department_name_id', $requestedDepartment) as $department)
                    foreach ($department->academicStaffs as $staff)
                        if ($staff->staffRank == "Associate Professor" || $staff->staffRank == "Professor")
                            $publications[] = $staff->publications;
            } else
                foreach ($college->departments()->where('department_name_id', $user->departmentName->id)->get() as $department)
                    foreach ($department->academicStaffs as $staff)
                        if ($staff->staffRank == "Associate Professor" || $staff->staffRank == "Professor")
                            $publications[] = $staff->publications;
        }

        $department = HierarchyService::getDepartment($institution, $collegeName, $departmentName, 'None', 'None', 'NONE');

        $publicationsAndPatents = PublicationsAndPatents::where(['department_id' => $department->id])->first();
        if ($publicationsAndPatents == null) {
            $publicationsAndPatents = new PublicationsAndPatents;
            $department->publicationsAndPatents()->save($publicationsAndPatents);
            return redirect('/department/publication');
        }

        $data = array(
            'publications' => $publications,
            'departments' => $collegeDeps,
            'publications_and_patents' => $publicationsAndPatents,

            'selected_department' => $requestedDepartment,

            'page_name' => 'publication.publication.index'
        );
        return view("staff.publication.index")->with($data);
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
        $institution = $user->institution();
        $collegeName = $user->collegeName;


        $staffs = array();
        /** @var College $college */
        foreach ($user->collegeName->college()->where([
            'education_level' => 'None', 'education_program' => 'None']) as $college) {
            foreach ($college->departments()->where([
                'department_name_id' => $user->departmentName->id, 'year_level' => 'None'])->get() as $department)
                foreach ($department->academicStaffs as $staff)
                    if ($staff->staffRank == "Associate Professor" || $staff->staffRank == "Professor")
                        $staffs[] = $staff;
        }

        $data = array(
            'staffs' => $staffs,
            'page_name' => 'publication.publication.create'
        );
        return view("staff.publication.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public
    function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'staff' => 'required',
            'date' => 'required|date|before:now'
        ]);

        $publication = new StaffPublication;
        $publication->title = $request->input('title');
        $publication->date_of_publication = $request->input('date');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');

        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = null;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = null;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $staff = AcademicStaff::where(['id' => $request->input('staff'), 'department_id' => $department->id])->first();

        $publication->academic_staff_id = $staff->id;

        if ($publication->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $publication->save();

        return redirect("/department/publication")->with('success', 'Successfully Added Publication');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function show($id)
    {
        return redirect("/department/publication");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function edit($id)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');

        $publication = StaffPublication::find($id);
        $staff = $publication->academicStaff()->first();
        $general = $staff->general()->first();

        $data = array(
            'id' => $id,
            'title' => $publication->title,
            'date' => $publication->date_of_publication,
            'author' => $general->name,
            'page_name' => 'staff.publication.edit'
        );

        return view("staff.publication.edit")->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public
    function update(Request $request, $id)
    {

        if ($request->input('publication') == 'true') {

            $this->validate($request, [
                'title' => 'required',
                'staff' => 'required',
                'date' => 'required|date|before:now'
            ]);

            $user = Auth::user();
            if ($user == null) return redirect('/login');
            $user->authorizeRoles('Department Admin');

            $publication = StaffPublication::find($id);

            $publication->title = $request->input("title");
            $publication->date_of_publication = $request->input("date");

            $publication->save();

            return redirect("/department/publication");
        }

        $this->validate($request, [
            'student_publications' => 'required|numeric|between:0,1000000000',
            'patents' => 'required|numeric|between:0,1000000000',
        ]);

        $publicationsAndPatents = PublicationsAndPatents::find($id);
        $publicationsAndPatents->student_publications = $request->input('student_publications');
        $publicationsAndPatents->patents = $request->input('patents');

        $user = Auth::user();
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $bandName = $user->bandName;
        $band = Band::where(['band_name_id' => $bandName->id, 'institution_id' => $institution->id])->first();
        if ($band == null) {
            $band = new Band;
            $band->band_name_id = null;
            $institution->bands()->save($band);
            $bandName->band()->save($band);
        }

        $collegeName = $user->collegeName;
        $college = College::where(['college_name_id' => $collegeName->id, 'band_id' => $band->id,
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = null;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = null;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->publicationsAndPatents()->save($publicationsAndPatents);

        return redirect("/department/publication")->with('success', 'Successfully Updated Publication');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public
    function destroy($id)
    {
        $item = StaffPublication::find($id);
        $item->delete();
        return redirect('/department/publication')->with('primary', 'Successfully Deleted');
    }
}
