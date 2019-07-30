@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Budget Descriptions</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/budgets/budget-description/create">New
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
                                >Budget Code
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending"
                                >Description
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($budgetDescriptions as $budgetDescription)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/budgets/budget-description/{{$budgetDescription->id}}/edit"
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
                                                        style="opacity:0.80" data-id="{{$budgetDescription->id}}"
                                                        data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash fa-sm"
                                                       style="opacity:0.75"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$budgetDescription->budget_code}}</td>
                                    <td>{{$budgetDescription->description}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.budget-description.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    {!! Form::open(['action'=>'College\BudgetDescriptionsController@store','method'=>'POST'])!!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/budgets/budget-description" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row p-4">
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('budget_code', old('budget_code'), ['class' => 'form-control', 'id' => 'add_budget_code', 'required' => 'true']) !!}
                            {!! Form::label('add_budget_code', 'Budget Code', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            {!! Form::text('description', old('description'), ['class' => 'form-control', 'id' => 'add_description', 'required' => 'true']) !!}
                            {!! Form::label('add_description', 'Budget Description', ['class' => 'form-control-placeholder']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close()!!}
                </div>

            </div>
        </div>
    @endif
    @if ($page_name == 'administer.budget-description.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="" action="/budgets/budget-description/{{$id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i></button>
                        {{-- <a href="/band/band-name" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a> --}}
                    </div>


                    <div class="modal-body row p-4">
                        <div class="col-md-12 form-group pb-1">
                            <label class="label" for="budget_code">Budget Code</label>
                            <input type="text" id="budget_code" name="budget_code" class="form-control"
                             value="{{$budget_code}}">
                        </div>
                        <div class="col-md-12 form-group pb-1">
                            <label class="label" for="description">Description</label>
                            <input type="text" id="description" name="description" class="form-control"
                             value="{{$description}}">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endSection
