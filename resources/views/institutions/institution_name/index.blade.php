@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Universities</div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/institution/institution-name/create">New
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
                                >Institution Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Acronym
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($institutions as $institution)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/institution/institution-name/{{$institution->id}}/edit"
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
                                                <form class="p-0"
                                                      action="/institution/institution-name/{{$institution->id}}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method"
                                                           value="DELETE">
                                                    <button type="submit"
                                                            class="btn btn-danger btn-circle text-white btn-sm mx-0"
                                                            style="opacity:0.80"
                                                            data-toggle="tooltip" title="Delete">
                                                        <i class="fas fa-trash fa-sm"
                                                           style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $institution->institution_name }}</td>
                                    <td>{{ $institution->acronym }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.institution-name.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'Institution\InstitutionNamesController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/institution/institution-name" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row p-4">
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('institution_name', null, ['class' => 'form-control', 'id' => 'add_institution_name', 'required' => 'true']) !!}
                            {!! Form::label('add_institution_name', 'University Name', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('institution_acronym', null, ['class' => 'form-control', 'id' => 'add_institution_acronym', 'required' => 'true']) !!}
                            {!! Form::label('add_institution_acronym', 'Acronym', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-12 form-group form-check pb-2 ml-3">
                            {!! Form::checkbox('is_private', null, null, ['id' => "is_private", 'class' =>'form-check-input']) !!}
                            {!! Form::label('is_private', "This is a Private Institution", ['class' => 'form-check-label']) !!}
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


    @if ($page_name == 'administer.institution-name.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Institution\InstitutionNamesController@update', $data['budget']->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/institution/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-6">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , $data['budget_type'], ['class' => 'form-control', 'id' => 'edit_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_description', \App\Models\Institution\BudgetDescription::all() , $data['budget_description'], ['class' => 'form-control', 'id' => 'edit_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', $data['budget']->allocated_budget, ['class' => 'form-control', 'id' => 'edit_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'edit_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', $data['budget']->additional_budget, ['class' => 'form-control', 'id' => 'edit_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'edit_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', $data['budget']->utilized_budget, ['class' => 'form-control', 'id' => 'edit_utilized', 'required' => 'true']) !!}
                            {!! Form::label('utilized', 'Utilized', ['class' => 'form-control-placeholder', 'for' => 'edit_utilized']) !!}
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you wish to delete?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/institution/budget/delete">
                        Delete
                    </a>

                </div>
            </div>
        </div>
    </div>

@endSection
