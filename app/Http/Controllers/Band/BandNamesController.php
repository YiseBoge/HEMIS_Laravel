<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * A class for the Admin to manage allowable Band Names
 */
class BandNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');

        $bands= BandName::all();
        $data = [
            'bands' => $bands,
            'page_name' => 'administer.band-name.list'
        ];
        return view('bands.band_name.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');

        $bands= BandName::all();
        $data = [
            'bands' => $bands,
            'page_name' => 'administer.band-name.create'
        ];
        return view('bands.band_name.list')->with($data);
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'band_name' => 'required',
            'band_acronym' => 'required'
        ]);

        $bandName = new BandName;
        $bandName->band_name = $request->input('band_name');
        $bandName->acronym = $request->input('band_acronym');
        $bandName->save();

        return redirect('/band/band-name');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');

        return view('bands.details');
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
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');

        return view('bands.edit');
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
