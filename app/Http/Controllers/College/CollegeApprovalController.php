<?php

namespace App\Http\Controllers\College;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApprovalService;
use Illuminate\Support\Facades\Auth;

class CollegeApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('colleges.approval');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                    ApprovalService::approveAllDepartmentDataInCollege($college);
                    
                }else if($type == "college"){
                    ApprovalService::approveAllCollegeData($college);                    
                }
            }
        }

        return redirect("college/approval")->with('primary', "Successfully Approved");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
