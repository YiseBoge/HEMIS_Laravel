<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\JobTitle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobTitlesController extends Controller
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

        $jobTitles = JobTitle::all();

        $data = array(
            'job_titles' => $jobTitles,
            'page_name' => 'administer.job_title.index',
        );

        return view('staff.job_title.index')->with($data);
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

        $jobTitles = JobTitle::all();
        $staffTypes = JobTitle::getEnum('staff_type');
        $levels = JobTitle::getEnum('level');

        $data = array(
            'job_titles' => $jobTitles,

            'staff_types' => $staffTypes,
            'levels' => $levels,
            'page_name' => 'administer.job_title.create',
        );

        return view('staff.job_title.index')->with($data);
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
            'job_title' => 'required',
            'staff_type' => 'required',
            'level' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $ictStaffTypes = new JobTitle();
        $ictStaffTypes->job_title = $request->input('job_title');
        $ictStaffTypes->staff_type = $request->input('staff_type');
        $ictStaffTypes->level = $request->input('level');

        if ($ictStaffTypes->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $ictStaffTypes->save();

        return redirect("staff/job-title");
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
        $user->authorizeRoles('Super Admin');

        $jobTitles = JobTitle::all();
        $selectedTitle = JobTitle::find($id);
        $levels = JobTitle::getEnum('level');

        $data = array(
            'job_titles' => $jobTitles,

            'selected_title' => $selectedTitle,
            'levels' => $levels,
            'page_name' => 'administer.job_title.edit',
        );

        return view('staff.job_title.index')->with($data);
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
            'job_title' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $jobTitle = JobTitle::find($id);
        $jobTitle->job_title = $request->input('job_title');

        $jobTitle->save();

        return redirect("staff/job-title");
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
        $item = JobTitle::find($id);
        $item->delete();
        return redirect('/staff/job-title')->with('primary', 'Successfully Deleted');
    }
}
