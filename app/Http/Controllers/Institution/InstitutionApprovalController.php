<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Services\ApprovalService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InstitutionApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $data = array(
            "page_name" => 'institutions.approval.index'
        );
        return view('institutions.approval')->with($data);
    }

    public function approve()
    {
        $user = Auth::user();
        $user->authorizeRoles('University Admin');

        $institution = $user->institution();

        ApprovalService::approveAllInInstitution($institution);

        return redirect("institution/approval")->with('primary', "Successfully Approved");
    }
}
