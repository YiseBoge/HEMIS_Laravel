<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Band\BandName;
use Exception;
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

        $bands = BandName::all();
        $data = [
            'bands' => $bands,

            'page_name' => 'administer.band-name.list',
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
        $user->authorizeRoles('Super Admin');

        $bands = BandName::all();
        $data = [
            'bands' => $bands,

            'has_modal' => 'yes',
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
        $this->validate($request, [
            'band_name' => 'required',
            'band_acronym' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $bandName = new BandName;
        $bandName->band_name = $request->input('band_name');
        $bandName->acronym = $request->input('band_acronym');

        if ($bandName->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $bandName->save();

        return redirect('/band/band-name')->with('success', 'Successfully Added Band Name');
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
        $user->authorizeRoles('Super Admin');
        return redirect('/band/band-name');
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
        $user->authorizeRoles('Super Admin');

        $bands = BandName::all();
        $current_band_name = BandName::findOrFail($id);
        $data = [
            'id' => $id,
            'bands' => $bands,
            'current_band_name' => $current_band_name,
            'band_name' => $current_band_name->band_name,
            'acronym' => $current_band_name->acronym,

            'has_modal' => 'yes',
            'page_name' => 'administer.band-name.edit'
        ];
        return view('bands.band_name.list')->with($data);
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
            'band_name' => 'required',
            'band_acronym' => 'required'
        ]);

        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $current_band_name = BandName::findOrFail($id);

        $current_band_name->band_name = $request->input("band_name");
        $current_band_name->acronym = $request->input("acronym");

        if ($current_band_name->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $current_band_name->save();
        return redirect('/band/band-name')->with('primary', 'Successfully Updated');

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
        $item = BandName::findOrFail($id);
        $item->delete();
        return redirect('/band/band-name')->with('primary', 'Successfully Deleted');
    }
}
