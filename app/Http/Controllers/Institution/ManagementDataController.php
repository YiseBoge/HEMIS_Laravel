<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\ManagementData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ManagementDataController extends Controller
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
        $institution = $user->institution();
        $managements = array();

        if ($institution != null) {
            foreach ($institution->managements as $management) {
                $managements[] = $management;
            }
        } else {
            $managements = ManagementData::all();
        }

        $data = [
            'management_data' => $managements,
            'page_name' => 'institutions.management_data.index'
        ];

        return view('institutions.management_data.index')->with($data);
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

        $institution = $user->institution();
        $managements = array();

        if ($institution != null) {
            foreach ($institution->managements as $management) {
                $managements[] = $management;
            }
        } else {
            $managements = ManagementData::all();
        }

        $data = [
            'management_data' => $managements,
            'management_levels' => ManagementData::getEnum('ManagementLevels'),

            'has_modal' => 'yes',
            'page_name' => 'institutions.management_data.create'
        ];

        return view('institutions.management_data.index')->with($data);
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
            'required_positions' => 'required',
            'assigned_positions' => 'required',
            'number_of_females' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');
        $institution = $user->institution();

        $management_data = new ManagementData();
        $management_data->required = $request->input('required_positions');
        $management_data->assigned = $request->input('assigned_positions');
        $management_data->female_number = $request->input('number_of_females');
        $management_data->management_level = $request->input('management_level');

        $management_data->institution_id = $institution->id;

        if ($management_data->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $management_data->save();

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
        return redirect('institution/management-data/');
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
        $user->authorizeRoles('University Admin');

        $institution = $user->institution();
        $managements = array();

        if ($institution != null) {
            foreach ($institution->managements as $management) {
                $managements[] = $management;
            }
        } else {
            $managements = ManagementData::all();
        }

        $data = [
            'management_data' => $managements,
            'management_levels' => ManagementData::getEnum('ManagementLevels'),
            'current' => ManagementData::find($id),

            'has_modal' => 'yes',
            'page_name' => 'institutions.management_data.edit',
        ];

        return view('institutions.management_data.index')->with($data);
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
            'required_positions' => 'required',
            'assigned_positions' => 'required',
            'number_of_females' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) return redirect('/login');
        $user->authorizeRoles('University Admin');
        $institution = $user->institution();

        $management_data = ManagementData::find($id);
        $management_data->required = $request->input('required_positions');
        $management_data->assigned = $request->input('assigned_positions');
        $management_data->female_number = $request->input('number_of_females');
        $management_data->management_level = $request->input('management_level');

        $management_data->save();

        return redirect('institution/management-data/')->with('primary', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = ManagementData::find($id);
        $item->delete();
        return redirect('institution/management-data')->with('primary', 'Successfully Deleted');
    }
}
