<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
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


        return redirect('/institution/semester-overview');
    }

}
