<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstancesController extends Controller
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
        $user->authorizeRoles('Super Admin');

        $instances = Instance::orderByDesc('year')->get();
        $currentInstance = $user->currentInstance;
        $currentInstanceIndex = 0;

        if ($currentInstance == null) {
            if (count($instances) == 1) {
                $ins = $instances[0];
                $ins->users()->save($user);
                return redirect('/institution/instance');
            }
        }
        if ($currentInstance != null) {
            for ($i = 0; $i < (count($instances)); $i++) {
                $inst = $instances[$i];
                if ($inst->id == $currentInstance->id) $currentInstanceIndex = $i;
            }
        }

        $data = [
            'instances' => $instances,
            'current_instance' => $currentInstance,
            'current' => $currentInstanceIndex,
            'page_name' => 'administer.instance.index'
        ];
        return view('institutions.instance.index')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $instances = Instance::orderByDesc('year')->get();
        $currentInstance = $user->currentInstance;
        $currentInstanceIndex = 0;

        for ($i = 0; $i < (count($instances)); $i++) {
            $inst = $instances[$i];
            if ($inst->id == $currentInstance->id) $currentInstanceIndex = $i;
        }

        $data = [
            'instances' => $instances,
            'years' => Instance::getEnum('year'),
            'current_instance' => $currentInstance,
            'current' => $currentInstanceIndex,

            'has_modal' => 'yes',
            'page_name' => 'administer.instance.create'
        ];
        return view('institutions.instance.index')->with($data);
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
            'year' => 'required',
            'semester' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $instance = new Instance();
        $instance->year = $request->input('year');
        $instance->semester = $request->input('semester');

        if ($instance->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $instance->save();

        return redirect('institution/instance')->with('success', 'Successfully Added Instance');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('institution/instance');
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
        $user->authorizeRoles('Super Admin');

        $instances = Instance::orderByDesc('year')->get();
        $currentInstanceIndex = 0;
        $selectedInstance = Instance::findOrFail($id);

        $data = array(
            'selected_instance' => $selectedInstance,
            'instances' => $instances,
            'years' => Instance::getEnum('year'),
            'current' => $currentInstanceIndex,

            'page_name' => 'administer.instance.edit',
        );

        return view('institutions.instance.index')->with($data);
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
            'year' => 'required',
            'semester' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $instance = Instance::findOrFail($id);
        $instance->year = $request->input('year');
        $instance->semester = $request->input('semester');

        $instance->save();

        return redirect('/institution/instance')->with('primary' , 'Successfully edited instance information');
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
        $item = Instance::findOrFail($id);
        $item->delete();
        return redirect('/institution/instance')->with('primary', 'Successfully Deleted');
    }


    /**
     * Update the current Instance of the admin
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function updateCurrentInstance(Request $request)
    {
        $this->validate($request, [
            'current_instance' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');
        $oldInstance = $user->currentInstance;
        $currentInstances = Instance::orderByDesc('year')->get();
        $currentInstance = $currentInstances[$request->input('current_instance')];

        $currentInstance->users()->save($user);

        $institutions = $oldInstance->institutions;
        /** @var Institution $oldInstitution */
        foreach ($institutions as $oldInstitution) {
            $institutionName = $oldInstitution->institutionName;

            $newSemester = User::adminInstance();
            if ($newSemester == $user->currentInstance) return redirect()->back()->with('primary', 'Already Upto Date');
            foreach ($institutionName->institutions as $institution) {
                if ($institution->instance_id == $newSemester->id) {
                    $this->transferInstitutionContents($oldInstitution, $institution, true);
                    $this->updateUserSemesters($institutionName, $newSemester);
                    return redirect('/institution/instance')->with('primary', 'Successfully Updated Current Semester');
                }
            }

            $generalInformation = $oldInstitution->generalInformation;

            $newInstitution = new Institution();
            $newInstitution->institution_name_id = $institutionName->id;
            $newInstitution->instance_id = $newSemester->id;

            $generalInformation->institution()->save($newInstitution);
            $newInstitution = $newInstitution->fresh();

            $this->transferInstitutionContents($oldInstitution, $newInstitution, false);
            $this->updateUserSemesters($institutionName, $newSemester);
        }

        return redirect('/institution/instance')->with('primary', 'Successfully Updated Current Semester');
    }

    /**
     * @param Institution $oldInstitution
     * @param Institution $newInstitution
     * @param bool $exists
     */
    private function transferInstitutionContents(Institution $oldInstitution, Institution $newInstitution, $exists)
    {
        foreach ($oldInstitution->colleges as $oldCollege) {
            $newCollege = $this->makeCollege($newInstitution, $oldCollege, $exists);
            foreach ($oldCollege->buildings as $building) {
                $building->college_id = $newCollege->id;
                $building->save();
            }
            foreach ($oldCollege->allAministrativeStaffs as $staff) {
                $staff->college_id = $newCollege->id;
                $staff->save();
            }
            foreach ($oldCollege->ictStaffs as $staff) {
                $staff->college_id = $newCollege->id;
                $staff->save();
            }
            foreach ($oldCollege->managementStaffs as $staff) {
                $staff->college_id = $newCollege->id;
                $staff->save();
            }
            foreach ($oldCollege->supportiveStaffs as $staff) {
                $staff->college_id = $newCollege->id;
                $staff->save();
            }

            $this->transferCollegeContents($oldCollege, $newCollege, $exists);
        }
    }

    /**
     * @param Institution $newInstitution
     * @param College $oldCollege
     * @param bool $exists
     * @return College|null
     */
    private function makeCollege(Institution $newInstitution, College $oldCollege, $exists)
    {
        if ($exists) {
            $model = College::where(array(
                'education_level' => $oldCollege->education_level,
                'education_program' => $oldCollege->education_program,
                'college_name_id' => $oldCollege->college_name_id,
                'institution_id' => $newInstitution->id,
            ))->first();
            if ($model != null) return $model;
        }
        $newCollege = new College();
        $newCollege->education_level = $oldCollege->education_level;
        $newCollege->education_program = $oldCollege->education_program;
        $newCollege->college_name_id = $oldCollege->college_name_id;
        $newCollege->institution_id = $newInstitution->id;
        $newCollege->save();
        $newCollege = $newCollege->fresh();
        return $newCollege;
    }

    /**
     * @param College $oldCollege
     * @param College $newCollege
     * @param bool $exists
     */
    private function transferCollegeContents(College $oldCollege, College $newCollege, $exists)
    {
        foreach ($oldCollege->departments as $oldDepartment) {
            $newDepartment = $this->makeDepartment($newCollege, $oldDepartment, $exists);
            foreach ($oldDepartment->allAcademicStaffs as $staff) {
                $staff->department_id = $newDepartment->id;
                $staff->save();
            }
            foreach ($oldDepartment->technicalStaffs as $staff) {
                $staff->department_id = $newDepartment->id;
                $staff->save();
            }
            foreach ($oldDepartment->specialNeedStudents as $student) {
                $student->department_id = $newDepartment->id;
                $student->save();
            }
            foreach ($oldDepartment->foreignStudents as $student) {
                $student->department_id = $newDepartment->id;
                $student->save();
            }
        }
    }

    /**
     * @param College $newCollege
     * @param $oldDepartment
     * @param bool $exists
     * @return Department|null
     */
    private function makeDepartment(College $newCollege, Department $oldDepartment, $exists)
    {
        if ($exists) {
            $model = Department::where(array(
                'year_level' => $oldDepartment->year_level,
                'department_name_id' => $oldDepartment->department_name_id,
                'college_id' => $newCollege->id,
            ))->first();
            if ($model != null) return $model;
        }
        $newDepartment = new Department();
        $newDepartment->year_level = $oldDepartment->year_level;
        $newDepartment->department_name_id = $oldDepartment->department_name_id;
        $newDepartment->college_id = $newCollege->id;
        $newDepartment->save();
        $newDepartment = $newDepartment->fresh();
        return $newDepartment;
    }

    /**
     * @param InstitutionName $institutionName
     * @param $newSemester
     */
    private function updateUserSemesters(InstitutionName $institutionName, $newSemester)
    {
        foreach ($institutionName->users as $institutionAdmin) {
            $institutionAdmin->instance_id = $newSemester->id;
            $institutionAdmin->save();
        }
        foreach ($institutionName->collegeNames as $collegeName) {
            foreach ($collegeName->users as $collegeAdmin) {
                $collegeAdmin->instance_id = $newSemester->id;
                $collegeAdmin->save();
            }
            foreach ($collegeName->departmentNames as $departmentName) {
                foreach ($departmentName->users as $departmentAdmin) {
                    $departmentAdmin->instance_id = $newSemester->id;
                    $departmentAdmin->save();
                }
            }
        }
    }
}
