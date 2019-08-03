<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\IctStaffType;
use Exception;
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
        $user->authorizeRoles('Super Admin');

        $categories = IctStaffType::getEnum('category');
        $ictStaffTypes = IctStaffType::all();

        $data = array(
            'categories' => $categories,
            'ict_staff_types' => $ictStaffTypes,

            'has_modal' => 'yes',
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
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'category' => 'required',
            'ict_staff_type' => 'required',
        ]);

        $ictStaffTypes = new IctStaffType();
        $ictStaffTypes->category = $request->input('category');
        $ictStaffTypes->type = $request->input('ict_staff_type');

        if ($ictStaffTypes->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $ictStaffTypes->save();

        return redirect('/staff/ict-staff-types')->with('success', 'Successfully Added ICT Staff Type');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/staff/ict-staff-types');
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
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $categories = IctStaffType::getEnum('category');
        $ictStaffTypes = IctStaffType::all();
        $current_type = IctStaffType::find($id);

        $data = array(
            'id' => $id,
            'categories' => $categories,
            'ict_staff_types' => $ictStaffTypes,
            'current_type' => $current_type,
            'category' => $current_type->category,
            'staff_type' => $current_type->type,

            'has_modal' => 'yes',
            'page_name' => 'administer.ict_staff_type.edit',
        );

        return view('staff.ict_staff_type.index')->with($data);
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
        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $current_type = IctStaffType::find($id);

        $current_type->type = $request->input("staff_type");
        $current_type->save();
        return redirect('/staff/ict-staff-types')->with('primary', 'Successfully Updated');
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
        $item = IctStaffType::find($id);
        $item->delete();
        return redirect('/staff/ict-staff-types')->with('primary', 'Successfully Deleted');
    }
}
