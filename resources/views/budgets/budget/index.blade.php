@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Budgets</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <form action="budget/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm" {{count($budgets) == 0 ? 'disabled' : ''}}>
                                    Approve All Pending<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                               href="budget/create">New Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
                    </div>
                @endif

                @if(Auth::user()->hasRole('College Super Admin'))
                @else
                    <div class="row">
                        {!! Form::open(['action' => 'College\BudgetsController@index', 'method' => 'GET', 'class' => 'w-100']) !!}
                        <div class="col-md-6 px-3 py-md-1">
                            <div class="form-group">
                                {!! Form::select('budget_type', $budget_types , $budget_type , ['class' => 'form-control', 'id' => 'set_budget_type', 'onchange' => 'this.form.submit()']) !!}
                                {!! Form::label('set_budget_type', 'Budget Type', ['class' => 'form-control-placeholder']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endif


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
                                @if(Auth::user()->hasRole('College Super Admin'))
                                    <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                        rowspan="1" colspan="1" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending"
                                    >Budget Type
                                    </th>
                                @endif
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >Budget Code
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >Budget Description
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(a) Allocated Budget
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(b) Additional Budget
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(c) Internal Transfer <br> (a &#177; b)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(d) Adjusted Budget <br> (a+b+c)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(e) Utilized Budget
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(f) Difference <br> (d-e)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                    style="min-width: 120px"
                                >(g) Performance <br> (e/d * 100) %
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="min-width: 95px;">Approval Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    @if(Auth::user()->hasRole('College Super Admin'))
                                        <td class="text-center">
                                            @if($budget->approval_status == "Pending")
                                                <form action="budget/{{$budget->id}}/approve"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80"
                                                            data-toggle="tooltip" title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>{{ $budget->budget_type }}</td>
                                    @else
                                        <td class="text-center">
                                            @if(!in_array($budget->approval_status, ["Approved", "College Approved"]))
                                                <div class="row px-1">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="budget/{{$budget->id}}/edit"
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
                                                                style="opacity:0.80" data-id="{{$budget->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $budget->budgetDescription->budget_code }}</td>
                                    <td>{{ $budget->budgetDescription->description }}</td>
                                    <td>{{ $a = $budget->allocated_budget }}</td>
                                    <td>{{ $b = $budget->additional_budget }}</td>
                                    <td>{{ $c = $a - $b }}</td>
                                    <td>{{ $d = $a + $b + $c }}</td>
                                    <td>{{ $e = $budget->utilized_budget }}</td>
                                    <td>{{ $f = $d - $e }}</td>
                                    <td>{{ $g = round(($e/$d) * 100, 2) }}%</td>
                                    @if($budget->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check-double"></i> {{$budget->approval_status}}
                                        </td>
                                    @elseif($budget->approval_status == "College Approved")
                                        <td class="text-primary"><i
                                                    class="fas fa-check"></i> {{$budget->approval_status}}
                                        </td>
                                    @elseif($budget->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$budget->approval_status}}
                                        </td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$budget->approval_status}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'budgets.budget.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'College\BudgetsController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/budgets/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">

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

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', $budget_types, old('budget_type') , ['class' => 'form-control', 'id' => 'add_budget_type']) !!}
                            {!! Form::label('add_budget_type', 'Budget Type', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_description', $budget_descriptions , old('budget_description') , ['class' => 'form-control', 'id' => 'add_budget_description']) !!}
                            {!! Form::label('add_budget_description', 'Budget Description', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', old('allocated'), ['class' => 'form-control', 'id' => 'add_allocated', 'required' => 'true']) !!}
                            {!! Form::label('add_allocated', 'Allocated', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', old('additional'), ['class' => 'form-control', 'id' => 'add_additional', 'required' => 'true']) !!}
                            {!! Form::label('add_additional', 'Additional', ['class' => 'form-control-placeholder']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', old('utilized'), ['class' => 'form-control', 'id' => 'add_utilized', 'required' => 'true']) !!}
                            {!! Form::label('add_utilized', 'Utilized', ['class' => 'form-control-placeholder']) !!}
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
                    {!! Form::open(['action' => ['College\BudgetsController@update', $selected_budget->id], 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Edit</h5>
                        <a href="/budgets/budget" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <div class="modal-body row pt-4">

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

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_type', $budget_types , $budget_type, ['class' => 'form-control', 'id' => 'edit_budget_type']) !!}
                            {!! Form::label('budget_type', 'Budget Type', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_type']) !!}
                        </div>

                        <div class="col-12 form-group pb-2">
                            {!! Form::select('budget_description', $budget_descriptions , $budget_description, ['class' => 'form-control', 'id' => 'edit_budget_description']) !!}
                            {!! Form::label('budget_description', 'Budget Description', ['class' => 'form-control-placeholder', 'for' => 'edit_budget_description']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('allocated', $selected_budget->allocated_budget, ['class' => 'form-control', 'id' => 'edit_allocated', 'required' => 'true']) !!}
                            {!! Form::label('allocated', 'Allocated', ['class' => 'form-control-placeholder', 'for' => 'edit_allocated']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('additional', $selected_budget->additional_budget, ['class' => 'form-control', 'id' => 'edit_additional', 'required' => 'true']) !!}
                            {!! Form::label('additional', 'Additional', ['class' => 'form-control-placeholder', 'for' => 'edit_additional']) !!}
                        </div>

                        <div class="col-md-4 form-group">
                            {!! Form::number('utilized', $selected_budget->utilized_budget, ['class' => 'form-control', 'id' => 'edit_utilized', 'required' => 'true']) !!}
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

@endSection