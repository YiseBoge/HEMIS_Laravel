<?php

namespace App\Http\Controllers\Institution;
use App\Http\Controllers\Controller;
use App\Models\Institution\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Institution\Institution;
use Webpatser\Uuid\Uuid;

class ManagementDatasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=['management_data'=>Management::all() , 'page_name'=>'institutions.management_data.index'];
        return view('institutions.management_data.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=['management_data'=>[],'page_name'=>'institutions.management_data.create',
         'management_levels'=>Management::getEnum('ManagementLevels')];
        return view('institutions.management_data.index')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        $institution = Institution::where('id', $user->institution_id)->first();

        $managment_data = new Management();

        $managment_data->required_position_number = $request->input('required_positions');
        $managment_data->currently_assigned_number = $request->input('assigned_positions');
        $managment_data->female_number = $request->input('number_of_females');
        $managment_data->management_level = $request->input('management_level');

        // die( $request->input('management_level'));

        $managment_data->institution_id = $institution->id;

        $managment_data->save();
        
        return redirect('institution/management-data/');
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
        // die('This is edit');
        $data=['page_name'=>'institutions.management_data.edit', 'management_data'=>[],
         'management_levels'=>Management::getEnum('ManagementLevels')];
        return view('institutions.management_data.index')->with('data',$data);
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
