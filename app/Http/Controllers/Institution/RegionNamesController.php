<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\RegionName;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegionNamesController extends Controller
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

        $regionNames = RegionName::all();

        $data = [
            'region_names' => $regionNames,
            'page_name' => 'administer.region-name.index'
        ];
        return view('institutions.region_name.index')->with($data);
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

        $regionNames = RegionName::all();
        $data = [
            'region_names' => $regionNames,

            'has_modal' => 'yes',
            'page_name' => 'administer.region-name.create'
        ];
        return view('institutions.region_name.index')->with($data);
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
            'name' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $regionNames = new RegionName;
        $regionNames->name = $request->input('name');

        if ($regionNames->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $regionNames->save();

        return redirect('/region-name')->with('success', 'Successfully Added Region Name');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('/region-name');
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

        $regionNames = RegionName::all();
        $current_region_name = RegionName::findOrFail($id);
        $data = [
            'id' => $id,
            'region_names' => $regionNames,
            'region_name' => $current_region_name->name,

            'has_modal' => 'yes',
            'page_name' => 'administer.region-name.edit'
        ];
        return view('institutions.region_name.index')->with($data);
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
            'region_name' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Super Admin');

        $current_region_name = RegionName::findOrFail($id);

        $current_region_name->name = $request->input("region_name");
        $current_region_name->save();

        return redirect('/region-name')->with('primary', 'Successfully Updated');
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
        $item = RegionName::findOrFail($id);
        $item->delete();
        return redirect('/region-name')->with('primary', 'Successfully Deleted');
    }
}
