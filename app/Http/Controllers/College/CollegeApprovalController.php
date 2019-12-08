<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Services\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CollegeApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('College Super Admin');

        $data = [
            "page_name" => 'college.approval.index'
        ];
        return view('colleges.approval')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('College Super Admin');

        $institution = $user->institution();

        $type = $request->input('type');

        $count = 0;
        foreach ($institution->colleges as $college) {
            if ($type == "department") {
                $count += ApprovalService::approveAllDepartmentDataInCollege($college, "college");

            } else if ($type == "college") {
                $count += ApprovalService::approveAllCollegeData($college, "college");
            }
        }

        if ($count == 0) $message = "No items to Approve";
        elseif ($count == 1) $message = "Successfully approved $count item.";
        else $message = "Successfully approved $count items.";

        return redirect("college/approval")->with($count == 0 ? 'primary' : 'success', $message);
    }
}
