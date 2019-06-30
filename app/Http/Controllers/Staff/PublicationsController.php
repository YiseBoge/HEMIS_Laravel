<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Department\PublicationsAndPatents;
use App\Models\Staff\AcademicStaff;
use App\Models\Staff\StaffPublication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PublicationsController extends Controller
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
        $user->authorizeRoles(['Department Admin', 'College Super Admin']);
        $institution = $user->institution();

        $publications = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $user->departmentName->department_name && $department->year_level == "None") {
                                    foreach ($department->academicStaffs as $staff) {
                                        foreach ($staff->publications as $publication) {
                                            $publications[] = $publication;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $publications = StaffPublication::with('department')->get();
        }

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
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $publicationsAndPatents = PublicationsAndPatents::where(['department_id' => $department->id])->first();
        if ($publicationsAndPatents == null) {
            $publicationsAndPatents = new PublicationsAndPatents;
            $department->publicationsAndPatents()->save($publicationsAndPatents);
            return redirect('/department/publication');
        }

        $data = array(
            'publications' => $publications,
            'publications_and_patents' => $publicationsAndPatents,
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $staffs = array();

        if ($institution != null) {
            foreach ($institution->bands as $band) {
                if ($band->bandName->band_name == $user->bandName->band_name) {
                    foreach ($band->colleges as $college) {
                        if ($college->collegeName->college_name == $user->collegeName->college_name && $college->education_level == "None" && $college->education_program == "None") {
                            foreach ($college->departments as $department) {
                                if ($department->departmentName->department_name == $user->departmentName->department_name && $department->year_level == "None") {
                                    foreach ($department->academicStaffs as $staff) {

                                        if ($staff->staffRank == "Associate Professor" || $staff->staffRank == "Professor") {

                                            $staffs[] = $staff;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $staffs = AcademicStaff::with('department')->get();
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required'
        ]);

        $publication = new StaffPublication;
        $publication->title = $request->input('title');
        $publication->date_of_publication = $request->input('date');

        $user = Auth::user();
        if ($user == null) return redirect('/login');
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
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $staff = AcademicStaff::where(['id' => $request->input('staff'), 'department_id' => $department->id])->first();

        $staff->publications()->save($publication);

        return redirect("/department/publication");
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
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'student_publications' => 'required',
            'patents' => 'required'
        ]);

        $publicationsAndPatents = PublicationsAndPatents::find($id);
        $publicationsAndPatents->student_publications = $request->input('student_publications');
        $publicationsAndPatents->patents = $request->input('patents');

        $user = Auth::user();
        if ($user == null) return redirect('/login');
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
            'education_level' => "None", 'education_program' => "None"])->first();
        if ($college == null) {
            $college = new College;
            $college->education_level = "None";
            $college->education_program = "None";
            $college->college_name_id = 0;
            $band->colleges()->save($college);
            $collegeName->college()->save($college);
        }

        $departmentName = $user->departmentName;
        $department = Department::where(['department_name_id' => $departmentName->id, 'year_level' => "None",
            'college_id' => $college->id])->first();
        if ($department == null) {
            $department = new Department;
            $department->year_level = "None";
            $department->department_name_id = 0;
            $college->departments()->save($department);
            $departmentName->department()->save($department);
        }

        $department->publicationsAndPatents()->save($publicationsAndPatents);

        return redirect("/department/publication");
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
}
