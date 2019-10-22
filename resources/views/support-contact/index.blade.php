@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Support Contacts</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/support-contacts/create">New
                            Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <table class="table table-bordered dataTable table-striped table-hover"
                               id="dataTable"
                               width="100%"
                               cellspacing="0" role="grid" aria-describedby="dataTable_info"
                               style="width: 100%;">

                            <thead>
                            <tr role="row">
                                <th style="min-width: 50px; width: 50px"></th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                > Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Phone
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Monday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Tuesday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Wednesday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Thursday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Friday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Saturday
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Sunday
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($support_contacts as $contact)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/support-contacts/{{$contact->id}}/edit"
                                                      method="GET">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-circle text-white btn-sm mx-0"
                                                            style="opacity:0.80"
                                                            data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt fa-sm"
                                                           style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col px-0">
                                                <button type="submit"
                                                        class="btn btn-danger btn-circle text-white btn-sm mx-0 deleter"
                                                        style="opacity:0.80" data-id="{{$contact->id}}"
                                                        data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash fa-sm"
                                                       style="opacity:0.75"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td >{{ $contact->name }}</td>
                                    <td >{{ $contact->phone }}</td>
                                    <td class="text-success">{{ $contact->available_on_monday ? 'Available' : ' ' }}</td>
                                    <td class="text-success">{{ $contact->available_on_tuesday ? 'Available' : ' ' }} </td>
                                    <td class="text-success">{{ $contact->available_on_wednesday ? 'Available' : ' ' }}</td>
                                    <td class="text-success">{{ $contact->available_on_thursday ? 'Available' : ' ' }}</td>
                                    <td class="text-success">{{ $contact->available_on_friday ? 'Available' : ' ' }}</td>
                                    <td class="text-success">{{ $contact->available_on_saturday ? 'Available' : ' ' }}</td>
                                    <td class="text-success">{{ $contact->available_on_sunday ? 'Available' : ' ' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.support-contact.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'SupportContactsController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/support-contacts" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12 form-group pb-1">
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'required' => 'true']) !!}
                            {!! Form::label('name', 'Contact Name', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col-md-12 form-group pb-1">
                                {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone', 'required' => 'true']) !!}
                                {!! Form::label('phone', 'Phone Number', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>
                        

                        <div class="row pl-3">
                            <div class="col-md-4 form-check mb-3 ">
                            {!! Form::checkbox('available_on_monday', null, !empty(old('available_on_monday')), ['id' => "available_on_monday", 'class' =>'mr-2 form-check-input']) !!}
                            {!! Form::label('available_on_monday', " Monday", ['class' => 'form-check-label']) !!}
                            
                            </div>
                            <div class="col-md-4 form-check   ">
                                {!! Form::checkbox('available_on_tuesday', null, !empty(old('available_on_tuesday')), ['id' => "available_on_tuesday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_tuesday', " Tuesday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-4 form-check   ">
                                {!! Form::checkbox('available_on_wednesday', null, !empty(old('available_on_wednesday')), ['id' => "available_on_wednesday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_wednesday', " Wednesday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_thursday', null, !empty(old('available_on_thursday')), ['id' => "available_on_thursday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_thursday', " Thursday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_friday', null, !empty(old('available_on_friday')), ['id' => "available_on_friday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_friday', " Friday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_saturday', null, !empty(old('available_on_saturday')), ['id' => "available_on_saturday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_saturday', " Saturday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_sunday', null, !empty(old('available_on_sunday')), ['id' => "available_on_sunday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_sunday', " Sunday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                        </div>
                        
                        
                    </div>


                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif


    @if ($page_name == 'administer.support-contact.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['SupportContactsController@update', $current_contact->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/support-contacts" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body  p-4">

                        @if(count($errors) > 0)
                            <div class="col-md-12 form-group">
                                <div class="alert alert-danger">
                                    <h6 class="font-weight-bold">Please fix the following issues</h6>
                                    <hr class="my-0">
                                    <ul class="my-1 px-4">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 form-group pb-1">
                            {!! Form::text('name', $current_contact->name, ['class' => 'form-control', 'id' => 'name', 'required' => 'true']) !!}
                            {!! Form::label('name', 'Contact Name', ['class' => 'form-control-placeholder']) !!}
                            </div>
                            <div class="col-md-12 form-group pb-1">
                                {!! Form::text('phone', $current_contact->phone, ['class' => 'form-control', 'id' => 'phone', 'required' => 'true']) !!}
                                {!! Form::label('phone', 'Phone Number', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>

                        <div class="row pl-3">
                            <div class="col-md-4 form-check mb-3 ">
                            {!! Form::checkbox('available_on_monday', null, $current_contact->available_on_monday, ['id' => "available_on_monday", 'class' =>'mr-2 form-check-input']) !!}
                            {!! Form::label('available_on_monday', " Monday", ['class' => 'form-check-label']) !!}
                            
                            </div>
                            <div class="col-md-4 form-check   ">
                                {!! Form::checkbox('available_on_tuesday', null, $current_contact->available_on_tuesday, ['id' => "available_on_tuesday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_tuesday', " Tuesday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-4 form-check   ">
                                {!! Form::checkbox('available_on_wednesday', null, $current_contact->available_on_wednesday, ['id' => "available_on_wednesday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_wednesday', " Wednesday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_thursday', null, $current_contact->available_on_thursday , ['id' => "available_on_thursday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_thursday', " Thursday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_friday', null, $current_contact->available_on_friday, ['id' => "available_on_friday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_friday', " Friday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_saturday', null, $current_contact->available_on_saturday, ['id' => "available_on_saturday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_saturday', " Saturday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                            <div class="col-md-3 form-check   ">
                                {!! Form::checkbox('available_on_sunday', null, $current_contact->available_on_sunday, ['id' => "available_on_sunday", 'class' =>'mr-2 form-check-input']) !!}
                                {!! Form::label('available_on_sunday', " Sunday", ['class' => 'form-check-label']) !!}
                                
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        {!! Form::hidden('_method', 'PUT') !!}
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    @endif

@endSection
