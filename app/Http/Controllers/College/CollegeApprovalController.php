<?php

namespace App\Http\Controllers\College;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApprovalService;
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

        foreach($institution->bands as $band){
            foreach($band->colleges as $college){
                if($type == "department"){
                    ApprovalService::approveAllDepartmentDataInCollege($college, "college");
                    
                }else if($type == "college"){
                    ApprovalService::approveAllCollegeData($college, "college");
                }
            }
        }

        return redirect("college/approval")->with('primary', "Successfully Approved");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
