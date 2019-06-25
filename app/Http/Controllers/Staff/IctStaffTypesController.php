<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\IctStaffType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * A class for the Admin to manage all allowable Ict Staff Types
 */
class IctStaffTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $ictStaffTypes = IctStaffType::all();
        $data = array(
            'ict_staff_types' => $ictStaffTypes,
            'page_name' => 'administer.ict_staff_type.index',
        );

        return view('staff.ict_staff_type.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $categories = IctStaffType::getEnum('category');
        $ictStaffTypes = IctStaffType::all();

        $data = array(
            'categories' => $categories,
            'ict_staff_types' => $ictStaffTypes,
            'page_name' => 'administer.ict_staff_type.create',
        );

        return view('staff.ict_staff_type.index')->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');

        $this->validate($request, [
            'category' => 'required',
            'ict_staff_type' => 'required',
        ]);

        $ictStaffTypes = new IctStaffType();
        $ictStaffTypes->category = $request->input('category');
        $ictStaffTypes->type = $request->input('ict_staff_type');

        $ictStaffTypes->save();

        return redirect('/staff/ict-staff-types');
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
