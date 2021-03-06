@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Academic Staff</h6>
            </div>
            <div class="card-body">
                <div class="row my-3">
                    <div class="col text-right">
                        <a class="btn btn-primary btn-sm mb-0 shadow-sm" href="/staff/academic/create">New Entry<i
                                    class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-striped table-hover" id="dataTable"
                           width="100%"
                           cellspacing="0" role="grid" aria-describedby="dataTable_info"
                           style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="Name: activate to sort column descending" width="15"
                                style="width: 15%;">Name
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                            >Job Title
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Dedication
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Employment Type
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1"
                                aria-label="Start date: activate to sort column ascending"
                            >Is Expatriate
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Age: activate to sort column ascending"
                            >Salary
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Academic Level
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                colspan="1" aria-label="Salary: activate to sort column ascending"
                            >Field of Study
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @if (count($staffs) > 0)
                            @foreach ($staffs as $staff)
                                <tr role="row" class="odd"
                                    onclick="window.location='academic/{{$staff->id}}'">
                                    <td class="sorting_1">{{$staff->general->name}}</td>
                                    <td>{{$staff->jobTitle}}</td>
                                    <td>{{$staff->general->dedication}}</td>
                                    <td>{{$staff->general->employment_type}}</td>
                                    @if ($staff->general->is_expatriate == 0)
                                        <td>No</td>
                                    @else
                                        <td>Yes</td>
                                    @endif
                                    <td>{{$staff->general->salary}}</td>
                                    <td>{{$staff->general->academic_level}}</td>
                                    <td>{{$staff->field_of_study}}</td>
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

@endsection
