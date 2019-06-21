<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Instance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstancesController extends Controller
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

        $instances = Instance::all();
        $currentInstance = Auth::user()->currentInstance;

        $data = ['instances' => $instances,
            'current_instance' => $currentInstance,
            'page_name' => 'administer.instance.index'
        ];
        return view('institutions.instance.index')->with($data);

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

        $instances = Instance::all();
        $currentInstance = $user->currentInstance;

        $data = [
            'instances' => $instances,
            'current_instance' => $currentInstance,
            'page_name' => 'administer.instance.create'
        ];
        return view('institutions.instance.index')->with($data);
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
            'year' => 'required',
            'semester' => 'required'
        ]);

        $instance = new Instance();
        $instance->year = $request->input('year');
        $instance->semester = $request->input('semester');

        $instance->save();

        return redirect('institution/instance');
    }


    /**
     * Update the current Instance of the admin
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function updateCurrentInstance(Request $request)
    {
        $this->validate($request, [
            'current_instance' => 'required'
        ]);

        $user = Auth::user();
        if ($user == null) abort(401, 'Login required.');
        $user->authorizeRoles('Super Admin');
        $currentInstances = Instance::all();
        $currentInstance = $currentInstances[$request->input('current_instance')];

        $currentInstance->users()->save($user);

        return redirect('institution/instance');
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
