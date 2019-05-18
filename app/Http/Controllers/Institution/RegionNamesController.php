<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\RegionName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegionNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $regionNames= RegionName::all();
        $data=['region_names'=>$regionNames,'page_name'=>'institution.region-name.index'];
        return view('institutions.region_name.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $regionNames= RegionName::all();
        $data=['region_names'=>$regionNames,'page_name'=>'institution.region-name.create'];
        return view('institutions.region_name.index')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $regionNames = new RegionName;
        $regionNames->name = $request->input('name');
        $regionNames->save();

        return redirect('/institution/region-name');
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
