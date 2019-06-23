@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foreign Staff</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/staff/foreign-staff/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table border dataTable table-striped table-hover" id="dataTable"
                                       width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th style="min-width: 50px; width: 50px"></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending" width="15"
                                            style="width: 15%;">Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Sex
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                        >Education Level
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Salary: activate to sort column ascending"
                                        >Specialization
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                        >Department
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Age: activate to sort column ascending"
                                        >Origin
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($data['staffs']) > 0)
                                        @foreach ($data['staffs'] as $staff)
                                            <tr role="row" class="odd"
                                                onclick="window.location='academic/{{$staff->id}}'">
                                                <td class="pl-4">
                                                    <div class="row">
                                                        <div class="col pt-1">
                                                            <a href="academic/{{$staff->id}}/edit"
                                                               class="text-primary mr-3"><i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <form class="p-0" action="/staff/academic/{{$staff->id}}"
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
                                                <td class="sorting_1">{{$staff->name}}</td>
                                                <td>{{$staff->sex}}</td>
                                                <td>{{$staff->education_level}}</td>
                                                <td>{{$staff->specialization}}</td>
                                                <td>{{$staff->department}}</td>
                                                <td>{{$staff->country_of_origin}}</td>
                                            </tr>
                                        @endforeach
                                    @else

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