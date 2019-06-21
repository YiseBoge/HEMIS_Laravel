<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffAttrition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StaffAttritionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('College Admin');
        $user->authorizeRoles(['College Admin', 'Department Admin']);
        $institution = $user->institution();

        $requestedCase = $request->input('case');
        if($requestedCase==null){
            $requestedCase='Government Appointment';
        }

        $requestedType = $request->input('type');
        if($requestedType==null){
            $requestedType='Management Staff';
        }

        $attritions = array();

        if($user->hasRole('Department Admin')){
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if($band->bandName->band_name == $user->bandName->band_name){
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if($department->departmentName->department_name == $user->departmentName->department_name){
                                        foreach($department->academicStaffs as $staff){
                                            $attrition = $staff->general->staffAttrition;
                                            if($attrition != null){
                                                //return "sgsdfa";
                                                $attritions[] = $attrition;
                                            } 
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                }
            } else {
                $attritions = StaffAttrition::all();
            }
        }else{
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if($band->bandName->band_name == $user->bandName->band_name){
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                $staffs = array();

                                if($requestedType == 'Management Staff'){
                                    $staffs = $college->managementStaffs;
                                }else if($requestedType == 'Technical Staff'){
                                    $staffs = $college->technicalStaffs;
                                }else if($requestedType == 'Administrative Staff'){
                                    $staffs = $college->administrativeStaffs;
                                }else if($requestedType == 'ICT Staff'){
                                    $staffs = $college->ictStaffs;
                                }else if($requestedType == 'Supportive Staff'){
                                    $staffs = $college->supportiveStaffs;
                                }    

                                foreach ($staffs as $staff) {
                                    $attrition = $staff->general->staffAttrition;
                                    if($attrition != null){
                                        $attritions[] = $attrition;
                                    } 
                                }
                            }
                        }
                    }
                    
                }
            } else {
                $attritions = StaffAttrition::all();
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'attritions' => $attritions,
            'cases' => StaffAttrition::getEnum("Cases"),
            'staff_types' => $staffTypes,

            'selected_type' => $requestedType,
            'selected_case' => $requestedCase,
            'page_name' => 'staff.attrition.index'
        );
        return view('staff.attrition.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles(['College Admin', 'Department Admin']);
        $institution = $user->institution();

        $requestedCase = $request->input('case');
        if($requestedCase==null){
            $requestedCase='Government Appointment';
        }

        $requestedType = $request->input('type');
        if($requestedType==null){
            $requestedType='Management Staff';
        }

        $attritions = array();
        $staffs = array();

        if($user->hasRole('Department Admin')){
            if ($institution != null) {
                foreach ($institution->bands as $band) {
                    if($band->bandName->band_name == $user->bandName->band_name){
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {
                                foreach ($college->departments as $department) {
                                    if($department->departmentName->department_name == $user->departmentName->department_name){
                                        foreach($department->academicStaffs as $staff){
                                            $attrition = $staff->general->staffAttrition;
                                            if($attrition != null){
                                                $attritions[] = $attrition;
                                            }else{
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
                $attritions = StaffAttrition::all();
            }
        }else{
            if ($institution != null) {                
                foreach ($institution->bands as $band) {
                    if($band->bandName->band_name == $user->bandName->band_name){
                        foreach ($band->colleges as $college) {
                            if ($college->collegeName->college_name == $user->collegeName->college_name) {                               
                                if($requestedType == 'Management Staff'){
                                    $currentStaffs = $college->managementStaffs;
                                }else if($requestedType == 'Technical Staff'){
                                    $currentStaffs = $college->technicalStaffs;
                                }else if($requestedType == 'Administrative Staff'){
                                    $currentStaffs = $college->administrativeStaffs;
                                }else if($requestedType == 'ICT Staff'){
                                    $currentStaffs = $college->ictStaffs;
                                }else if($requestedType == 'Supportive Staff'){
                                    $currentStaffs = $college->supportiveStaffs;
                                }    

                                foreach ($currentStaffs as $staff) {
                                    
                                    $attrition = $staff->general->staffAttrition;
                                    if($attrition != null){
                                        
                                        $attritions[] = $attrition;
                                    }else{
                                        //return $staff;
                                        $staffs[] = $staff;
                                    }
                                }
                            }
                        }
                    }
                    
                }
            } else {
                $attritions = StaffAttrition::all();
            }
        }

        $staffTypes = array(
            'Management Staff', 'Technical Staff', 'Administrative Staff', 'ICT Staff', 'Supportive Staff'
        );

        $data = array(
            'staffs' => $staffs,
            'attritions' => $attritions,
            'cases' => StaffAttrition::getEnum("Cases"),
            'staff_types' => $staffTypes,

            'selected_type' => $requestedType,
            'selected_case' => $requestedCase,
            'page_name' => 'staff.attrition.create'
        );
        return view('staff.attrition.index')->with($data);
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles(['College Admin', 'Department Admin']);

        $attrition = new StaffAttrition;
        $attrition->case = $request->input('case');

        //return $request->input('staff');
        $staff = Staff::get()->find($request->input('staff'));
        $staff->staffAttrition()->save($attrition);

        return redirect('/staff/attrition');

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
     */
    public function update(Request $request, $id)
    {
        //
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
