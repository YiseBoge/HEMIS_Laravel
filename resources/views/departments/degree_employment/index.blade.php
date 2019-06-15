@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Students Accessing Degree-relevant Employment Within 12
                    Months After Graduation </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col text-right">
                                <a class="btn btn-outline-primary btn-sm mb-0" href="degree-relevant-employment/create">New
                                    Entry<i
                                            class="fas fa-arrow-right ml-2"></i></a>

                            </div>
                        </div>

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
                                            style="width: 151px;">Department
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                            style="width: 46px;">Number of Male Students
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 99px;">Number of Female Students
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($employments) > 0)
                                        @foreach ($employments as $employment)
                                            <tr role="row" class="odd"
                                                onclick="window.location='/student/degree-relevant-employment/{{$employment->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="normal/{{$employment->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0"
                                                                  action="/student/degree-relevant-employment/{{$employment->id}}"
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
                                                <td>{{$employment->department->departmentName->department_name}}</td>
                                                <td>{{$employment->male_students_number}}</td>
                                                <td>{{$employment->female_students_number}}</td>
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
