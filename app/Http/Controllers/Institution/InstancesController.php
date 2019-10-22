<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Models\Institution\Instance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InstancesController extends Controller
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

        $instances = Instance::orderByDesc('year')->get();
        $currentInstance = $user->currentInstance;
        $currentInstanceIndex = 0;

        if ($currentInstance == null) {
            if (count($instances) == 1) {
                $ins = $instances[0];
                $ins->users()->save($user);
                return redirect('/institution/instance');
            }
        }
        if ($currentInstance != null) {
            for ($i = 0; $i < (count($instances)); $i++) {
                $inst = $instances[$i];
                if ($inst->id == $currentInstance->id) $currentInstanceIndex = $i;
            }
        }

        $data = [
            'instances' => $instances,
            'current_instance' => $currentInstance,
            'current' => $currentInstanceIndex,
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
        $user->authorizeRoles('Super Admin');

        $instances = Instance::orderByDesc('year')->get();
        $currentInstance = $user->currentInstance;
        $currentInstanceIndex = 0;

        for ($i = 0; $i < (count($instances)); $i++) {
            $inst = $instances[$i];
            if ($inst->id == $currentInstance->id) $currentInstanceIndex = $i;
        }

        $data = [
            'instances' => $instances,
            'years' => Instance::getEnum('year'),
            'current_instance' => $currentInstance,
            'current' => $currentInstanceIndex,

            'has_modal' => 'yes',
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
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'year' => 'required',
            'semester' => 'required'
        ]);

        $instance = new Instance();
        $instance->year = $request->input('year');
        $instance->semester = $request->input('semester');

        if ($instance->isDuplicate()) return redirect()->back()
            ->withInput($request->toArray())
            ->withErrors('This entry already exists');

        $instance->save();

        return redirect('institution/instance')->with('success', 'Successfully Added Instance');
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
        $user->authorizeRoles('Super Admin');
        $currentInstances = Instance::orderByDesc('year')->get();
        $currentInstance = $currentInstances[$request->input('current_instance')];

        $currentInstance->users()->save($user);

        return redirect('institution/instance')->with('primary', 'Updated Current Instance');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('institution/instance');
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

        $instances = Instance::orderByDesc('year')->get();
        $currentInstanceIndex = 0;
        $instance = Instance::find($id);

        $data = array(
            'instance' => $instance,
            'instances' => $instances,
            'current' => $currentInstanceIndex,

            'page_name' => 'administer.instance.edit',
        );

        return view('institutions.instance.index')->with($data);
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
        $user->authorizeRoles('Super Admin');

        $instance = Instance::find($id);

        $instance->year = $request->input('year');
        $instance->semester = $request->input('semester');

        $instance->save();

        return redirect('/institution/instance')->with('primary' , 'Successfully edited instance information');
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
        $item = Instance::find($id);
        $item->delete();
        return redirect('/institution/instance')->with('primary', 'Successfully Deleted');
    }
}
