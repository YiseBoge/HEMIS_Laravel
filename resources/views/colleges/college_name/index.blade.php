@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">Colleges</div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/college/college-name/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive col-12 py-3">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
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
                                            >College Name
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Acronym
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($colleges as $college)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $college->college_name }}</td>
                                                <td>{{ $college->acronym }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.colleges-name.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\CollegeNamesController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/college/college-name" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>


                    <div class="modal-body row pt-4">
                        <div class="col-12 form-group pb-2">
                            {{Form::text('college_name','',['class'=>'form-control','placeholder'=>'Add New College'])}}
                        </div>
                        <div class="col-12 form-group pb-2">
                            {{Form::text('college_acronym','',['class'=>'form-control','placeholder'=>'Acronym'])}}
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


    @if ($page_name == 'budgets.budget.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Institution\BudgetsController@update', $budget->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/institution/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-6">
                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', \App\Models\Institution\Budget::getEnum('budget_type') , $budget_type, ['class' => 'form-control', 'id' => 'edit_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {{--TODO get from budget descriptions--}}
                            {!! Form::select('budget_description', \App\Models\Institution\BudgetDescription::all() , $budget_description, ['class' => 'form-control', 'id' => 'edit_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', $budget->allocated_budget, ['class' => 'form-control', 'id' => 'edit_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'edit_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', $budget->additional_budget, ['class' => 'form-control', 'id' => 'edit_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'edit_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', $budget->utilized_budget, ['class' => 'form-control', 'id' => 'edit_utilized', 'required' => 'true']) !!}
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
