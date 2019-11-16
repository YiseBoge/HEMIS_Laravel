<?php

namespace App\Http\Controllers;

use App\Models\SupportContact;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SupportContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('publicView');
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

        $support_contacts = SupportContact::all();
        $data = [
            'support_contacts' => $support_contacts,
            'page_name' => 'administer.support-contact.index'
        ];
        return view('support-contact.index')->with($data);
    }

    public function publicView()
    {
        $weekMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',];

        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $todayContacts = SupportContact::where('available_on_' . $weekMap[$dayOfTheWeek], true)->get();
        $data = [
            'contacts' => $todayContacts
        ];
        return view('support-contact.public')->with($data);
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

        $support_contacts = SupportContact::all();
        $data = [
            'support_contacts' => $support_contacts,
            'has_modal' => 'yes',
            'page_name' => 'administer.support-contact.create'
        ];
        return view('support-contact.index')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);

        $contact = new SupportContact([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        $contact->available_on_monday = $request->has('available_on_monday');
        $contact->available_on_tuesday = $request->has('available_on_tuesday');
        $contact->available_on_wednesday = $request->has('available_on_wednesday');
        $contact->available_on_thursday = $request->has('available_on_thursday');
        $contact->available_on_friday = $request->has('available_on_friday');
        $contact->available_on_saturday = $request->has('available_on_saturday');
        $contact->available_on_sunday = $request->has('available_on_sunday');

        $contact->save();

        return redirect('/support-contacts')->with('success', 'Successfully Added Contact Person');
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

        $support_contacts = SupportContact::all();

        $contact = SupportContact::find($id);
        $data = [
            'support_contacts' => $support_contacts,
            'current_contact' => $contact,

            'has_modal' => 'yes',
            'page_name' => 'administer.support-contact.edit'
        ];

        return view('support-contact.index')->with($data);
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
        $user = Auth::user();
        $user->authorizeRoles('Super Admin');

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);

        $contact = SupportContact::findOrFail($id);

        $contact->name = $request->input('name');
        $contact->phone = $request->input('phone');

        $contact->available_on_monday = $request->has('available_on_monday');
        $contact->available_on_tuesday = $request->has('available_on_tuesday');
        $contact->available_on_wednesday = $request->has('available_on_wednesday');
        $contact->available_on_thursday = $request->has('available_on_thursday');
        $contact->available_on_friday = $request->has('available_on_friday');
        $contact->available_on_saturday = $request->has('available_on_saturday');
        $contact->available_on_sunday = $request->has('available_on_sunday');

        $contact->save();


        return redirect('/support-contacts')->with('primary', 'Successfully Edited Contact Person');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = SupportContact::find($id);
        $item->delete();
        return redirect('/support-contacts')->with('primary', 'Successfully Deleted');
    }
}
