@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Population Data</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/population/create">New
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
                                    aria-label="Name: activate to sort column descending">Age Range
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending">Males
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="Acronym: activate to sort column ascending">Females
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($populations as $pop)
                                <tr>
                                    <td class="text-center">
                                        <div class="row px-1">
                                            <div class="col px-0">
                                                <form class="p-0"
                                                      action="/population/{{$pop->id}}/edit"
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
                                                        style="opacity:0.80" data-id="{{$pop->id}}"
                                                        data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash fa-sm"
                                                       style="opacity:0.75"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $pop->age_range }}</td>
                                    <td>{{ $pop->male_number }}</td>
                                    <td>{{ $pop->female_number }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if ($page_name == 'administer.population.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    {!! Form::open(['action' => 'Institution\PopulationController@store', 'method' => 'POST']) !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTitle">Add</h5>
                        <a href="/population" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>


                    <div class="modal-body row p-4">

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

                        <div class="col-md-12 form-group pb-1">
                            {!! Form::select('age_range', $age_ranges , old('age_range'), ['class' => 'form-control', 'id' => 'add_age_range', 'required' => 'true']) !!}
                            {!! Form::label('add_age_range', 'Age Range', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-6 form-group pb-1">
                            {!! Form::number('male_number', old('male_number'), ['class' => 'form-control', 'id' => 'add_male_number', 'required' => 'true']) !!}
                            {!! Form::label('add_male_number', 'Males', ['class' => 'form-control-placeholder']) !!}
                        </div>
                        <div class="col-md-6 form-group pb-1">
                            {!! Form::number('female_number', old('female_number'), ['class' => 'form-control', 'id' => 'add_female_number', 'required' => 'true']) !!}
                            {!! Form::label('add_female_number', 'Females', ['class' => 'form-control-placeholder']) !!}
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


    @if ($page_name == 'administer.population.edit')
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form class="" action="/population/{{$population->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTitle">Edit</h5>
                            <a href="/population" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>


                        <div class="modal-body row p-4">

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

                            <div class="col-md-12 form-group pb-1">
                                <label class="label" for="edit_age_range">Age Range</label>
                                <input type="text" id="edit_age_range" name="age_range" class="form-control" disabled
                                       value="{{$population->age_range}}">
                            </div>
                            <div class="col-md-6 form-group pb-1">
                                <label class="label" for="edit_male_number">Males</label>
                                <input type="number" id="edit_male_number" name="male_number" class="form-control"
                                       value="{{$population->male_number}}">
                            </div>
                            <div class="col-md-6 form-group pb-1">
                                <label class="label" for="edit_female_number">Females</label>
                                <input type="number" id="edit_female_number" name="female_number" class="form-control"
                                       value="{{$population->female_number}}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Save Changes', ['class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif

@endSection
