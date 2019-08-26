<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Band\Band;
use App\Models\College\College;
use App\Models\Department\Department;
use App\Models\Institution\CommunityService;
use App\Models\Institution\GeneralInformation;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Models\Institution\Resource;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InstitutionInstancesController extends Controller
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
        $user->authorizeRoles('University Admin');

        $data = [
            'page_name' => 'report.institution_instance.index'
        ];
        return view('reports.institution_instance.index')->with($data);
    }

    /**
     * Change current semester to new Semester.
     *
     * @return Response
     */
    public function changeSemester()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $oldInstitution = $user->institution();
        $institutionName = $oldInstitution->institutionName;

        $newSemester = User::adminInstance();
        if ($newSemester == $user->currentInstance) return redirect()->back()->with('primary', 'Already Upto Date');
        foreach ($institutionName->institutions as $institution) {
            if ($institution->instance_id == $newSemester->id) {
                $this->transferInstitutionContents($oldInstitution, $institution, true);
                $this->updateUserSemesters($institutionName, $newSemester);
                return redirect('/institution/semester-overview')->with('primary', 'Successfully Switched to the new Semester');
            }
        }

        $generalInformation = new GeneralInformation();
        $communityService = new CommunityService();
        $resource = new Resource();

        $generalInformation->save();
        $communityService->save();
        $resource->save();

        $generalInformation->communityService()->associate($communityService)->save();
        $generalInformation->resource()->associate($resource)->save();

        $newInstitution = new Institution();
        $newInstitution->institution_name_id = $institutionName->id;
        $newInstitution->instance_id = $newSemester->id;

        $generalInformation->institution()->save($newInstitution);
        $newInstitution = $newInstitution->fresh();

        $this->transferInstitutionContents($oldInstitution, $newInstitution, false);
        $this->updateUserSemesters($institutionName, $newSemester);

        return redirect('/institution/semester-overview')->with('primary', 'Successfully Switched to the new Semester');
    }

    /**
     * @param Institution $oldInstitution
     * @param Institution $newInstitution
     * @param bool $exists
     */
    private function transferInstitutionContents(Institution $oldInstitution, Institution $newInstitution, $exists)
    {
        foreach ($oldInstitution->bands as $oldBand) {
            $newBand = $this->makeBand($newInstitution, $oldBand, $exists);
            $this->transferBandContents($oldBand, $newBand, $exists);
        }
    }

    /**
     * @param Institution $newInstitution
     * @param Band $oldBand
     * @param bool $exists
     * @return Band|null
     */
    private function makeBand(Institution $newInstitution, Band $oldBand, $exists)
    {
        if ($exists) {
            $model = Band::where(array(
                'institution_id' => $newInstitution->id,
                'band_name_id' => $oldBand->band_name_id,
            ))->first();
            if ($model != null) return $model;
        }
        $newBand = new Band();
        $newBand->institution_id = $newInstitution->id;
        $newBand->band_name_id = $oldBand->id;
        $newBand->save();
        $newBand = $newBand->fresh();
        return $newBand;
    }

    /**
     * @param Band $oldBand
     * @param Band $newBand
     * @param bool $exists
     */
    private function transferBandContents(Band $oldBand, Band $newBand, $exists)
    {
        foreach ($oldBand->colleges as $oldCollege) {
            $newCollege = $this->makeCollege($newBand, $oldCollege, $exists);
            foreach ($oldCollege->buildings as $building) {
                $building->college_id = $newCollege->id;
                $building->save();
            }
            foreach ($oldCollege->administrativeStaffs as $staff) {
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
            foreach ($oldCollege->technicalStaffs as $staff) {
                $staff->college_id = $newCollege->id;
                $staff->save();
            }

            $this->transferCollegeContents($oldCollege, $newCollege, $exists);
        }
    }

    /**
     * @param Band $newBand
     * @param College $oldCollege
     * @param bool $exists
     * @return College|null
     */
    private function makeCollege(Band $newBand, College $oldCollege, $exists)
    {
        if ($exists) {
            $model = College::where(array(
                'education_level' => $oldCollege->education_level,
                'education_program' => $oldCollege->education_program,
                'college_name_id' => $oldCollege->college_name_id,
                'band_id' => $newBand->id,
            ))->first();
            if ($model != null) return $model;
        }
        $newCollege = new College();
        $newCollege->education_level = $oldCollege->education_level;
        $newCollege->education_program = $oldCollege->education_program;
        $newCollege->college_name_id = $oldCollege->college_name_id;
        $newCollege->band_id = $newBand->id;
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
            foreach ($oldDepartment->academicStaffs as $staff) {
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
