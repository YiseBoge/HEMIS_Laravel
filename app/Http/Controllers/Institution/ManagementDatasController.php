<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Management;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManagementDatasController extends Controller
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
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $managements = array();

        if ($institution != null) {
            foreach ($institution->managements as $management) {
                $managements[] = $management;
            }
        } else {
            $managements = Management::all();
        }

        $data = [
            'management_data' => $managements,
            'page_name' => 'institutions.management_data.index'
        ];
        return view('institutions.management_data.index')->with('data', $data);
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
        $user->authorizeRoles('Department Admin');

        $data = ['management_data' => [], 'page_name' => 'institutions.management_data.create',
            'management_levels' => Management::getEnum('ManagementLevels')];
        return view('institutions.management_data.index')->with('data', $data);
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
        // die('dead');
        $this->validate($request, [
            'required_positions' => 'required',
            'assigned_positions' => 'required',
            'number_of_females' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('Department Admin');
        $institution = $user->institution();

        $management_data = new Management();

        $management_data->required_position_number = $request->input('required_positions');
        $management_data->currently_assigned_number = $request->input('assigned_positions');
        $management_data->female_number = $request->input('number_of_females');
        $management_data->management_level = $request->input('management_level');

        $institution->managements()->save($management_data);

        return redirect('institution/management-data/');
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
        // die('This is edit');
        $data = ['page_name' => 'institutions.management_data.edit', 'management_data' => [],
            'management_levels' => Management::getEnum('ManagementLevels')];
        return view('institutions.management_data.index')->with('data', $data);
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
