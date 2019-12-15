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
        $levels = IctStaffType::getEnum('level');

        $data = array(
            'categories' => $categories,
            'ict_staff_types' => $ictStaffTypes,
            'levels' => $levels,

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
        $this->validate($request, [
            'category' => 'required',
            'level' => 'required',
            'ict_staff_type' => 'required',
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $ictStaffTypes = new IctStaffType();
        $ictStaffTypes->category = $request->input('category');
        $ictStaffTypes->level = $request->input('level');
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
        $levels = IctStaffType::getEnum('level');
        $ictStaffTypes = IctStaffType::all();
        $current_type = IctStaffType::findOrFail($id);

        $data = array(
            'id' => $id,
            'categories' => $categories,
            'levels' => $levels,
            'ict_staff_types' => $ictStaffTypes,
            'current_type' => $current_type,

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
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required',
            'level' => 'required',
            'ict_staff_type' => 'required',
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $current_type = IctStaffType::findOrFail($id);

        $current_type->category = $request->input("category");
        $current_type->level = $request->input("level");
        $current_type->type = $request->input("ict_staff_type");

        if ($current_type->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

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
        $item = IctStaffType::findOrFail($id);
        $item->delete();
        return redirect('/staff/ict-staff-types')->with('primary', 'Successfully Deleted');
    }
}
