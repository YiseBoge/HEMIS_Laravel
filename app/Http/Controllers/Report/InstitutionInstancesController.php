<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
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
                $this->updateUserSemesters($institutionName, $newSemester);
                return redirect('/institution/semester-overview')->with('primary', 'Successfully shifted to the new Semester');
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

        $institution = new Institution();
        $institution->institution_name_id = $institutionName->id;
        $institution->instance_id = $newSemester->id;

        $generalInformation->institution()->save($institution);

        $this->updateUserSemesters($institutionName, $newSemester);

        return redirect('/institution/semester-overview')->with('primary', 'Successfully shifted to the new Semester');
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
