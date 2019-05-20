@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student Attrition</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="student-attrition/create">New Entry<i
                                            class="fas fa-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                        <form action="" method="get">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="band" id="band" onchange="this.form.submit()">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="band" class="form-control-placeholder">
                                        Education Program
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="type" id="type" onchange="this.form.submit()">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="case" id="case">
                                        @foreach ($cases as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="case" class="form-control-placeholder">
                                        Case
                                    </label>
                                </div>
                            </div>
                        </form>
                        <hr>
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
                                            style="width: 151px;">Band
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Male Students
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Female Students
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($attritions) > 0)
                                        @foreach ($attritions as $attrition)
                                            <tr role="row" class="odd"
                                                onclick="window.location='normal/{{$attrition->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="normal/{{$attrition->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0"
                                                                  action="/atudent-attrition/normal/{{$attrition->id}}"
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
                                                <td>{{$attrition->band->bandName->band_name}}</td>
                                                <td>{{$attrition->male_students_number}}</td>
                                                <td>{{$attrition->female_students_number}}</td>
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