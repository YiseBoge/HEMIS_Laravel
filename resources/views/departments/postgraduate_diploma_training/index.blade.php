@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Post Graduate Diploma Training</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                           href="/department/postgraduate-diploma-training/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0"
                                   href="">New Entry<i
                                            class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <form action="" method="get">
                            <div class="form-group row pt-3">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="type" id="type" onchange="this.form.submit()">
                                        @foreach ($types as $key => $value)
                                            @if ($value == $selected_type)
                                                <option value="{{$value}}" selected>{{$value}}</option>
                                            @else
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Teacher Type
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="program" id="program"
                                            onchange="this.form.submit()">
                                        @foreach ($programs as $key => $value)
                                            @if ($value == $selected_program)
                                                <option value="{{$value}}" selected>{{$value}}</option>
                                            @else
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                    <label for="service_type" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                            </div>

                        </form>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                                       width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 121px;">Department
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Male Teachers
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Teachers
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($trainings) > 0)
                                        @foreach ($trainings as $training)
                                            <tr role="row" class="odd"
                                                onclick="window.location='postgraduate-diploma-training/{{$training->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="postgraduate-diploma-training/{{$training->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0"
                                                                  action="/department/postgraduate-diploma-training/{{$training->id}}"
                                                                  method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit"
                                                                        class="form-control form-control-plaintext text-danger p-0">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{$training->department->departmentName->department_name}}</td>
                                                <td>{{$training->number_of_male_students}}</td>
                                                <td>{{$training->number_of_female_students}}</td>
                                            </tr>
                                        @endforeach
                                    @endif


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
