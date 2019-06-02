@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="text-primary card-header">University Industry Linkage</div>
            <div class="card-body">
                <div class="row">
                    <div class="col p-1 m-3 text-center">
                        <a href="/institution/university-industry-linkage/create" class="btn btn-outline-primary btn-sm mb-0">
                            Add<i class="fas fa-plus ml-2"></i></a>
                    </div>
                </div>
                <form action="" method="get">
                    <div class="form-group row pt-3">
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="year" id="year" onchange="this.form.submit()">
                                @foreach ($years as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <label for="year" class="form-control-placeholder">
                                Year Level
                            </label>
                        </div>
                    </div>
                </form>

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
                                            >Band
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Number of Industries Linked
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Training Area
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Acronym: activate to sort column ascending"
                                            >Number of Students
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($linkages as $linkage)
                                            <tr>
                                                <td class="text-center">
                                                    <a href=""
                                                       class="mr-2 d-inline text-primary"><i
                                                                class="far fa-edit"></i> </a>
                                                    <a href="" class="d-inline text-danger" data-toggle="modal"
                                                       data-target="#deleteModal"><i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $linkage->band->bandName->band_name }}</td>
                                                <td>{{ $linkage->number_of_industry_links }}</td>
                                                <td>{{ $linkage->training_area }}</td>
                                                <td>{{ $linkage->number_of_students }}</td>
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

    @if ($page_name == 'bands.university_industry_linkage.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form class="pb-5" action="/institution/university-industry-linkage" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/institution/university-industry-linkage" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>


                    <div class="modal-body pt-4">
                        <div class="form-group row pt-3">
                                <div class="col form-group">
                                        <select class="form-control" name="year" id="year">
                                            @foreach ($years as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <label for="year" class="form-control-placeholder">
                                                Year Level
                                        </label>
                                    </div>
                        </div>
                        <div class="form-group row pt-3">
                            
                            <div class="col form-group">
                                <input type="text" id="industry_number" name="industry_number" class="form-control" required>
                                <label class="form-control-placeholder" for="industry_number">Number of Industries Linked</label>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <div class="col form-group">
                                <input type="text" id="training_area" name="training_area" class="form-control" required>
                                <label class="form-control-placeholder" for="training_area">Training Area</label>
                            </div>
                            <div class="col form-group">
                                <input type="text" id="number_of_students" name="number_of_students" class="form-control" required>
                                <label class="form-control-placeholder" for="number_of_students">Number of Students</label>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>

                    </form>
                </div>

            </div>
        </div>
    @endif


    @if ($page_name == 'institution.budget.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => ['Institution\BudgetsController@update', $data['budget']->id], 'method' => 'POST']) !!}
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
                            {{--TODO get from budget descriptions--}}
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
