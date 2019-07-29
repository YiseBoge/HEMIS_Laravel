@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">University Industry Linkage</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->hasRole('College Super Admin'))
                    <div class="row my-3">
                        <div class="col text-right">
                            <form action="university-industry-linkage/0/approve" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approveAll">
                                <button type="submit"
                                        class="btn btn-sm btn-primary shadow-sm">
                                    Approve All Pending<i class="fas fa-check text-white-50 ml-2 fa-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row my-3">
                        <div class="col text-right">
                            <a class="btn btn-primary btn-sm mb-0 shadow-sm"
                               href="/student/university-industry-linkage/create">New Entry<i
                                        class="fas fa-plus text-white-50 fa-sm ml-2"></i></a>
                        </div>
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
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending"
                                >Year
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
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1"
                                    aria-label="Start date: activate to sort column ascending"
                                    style="min-width: 99px;">Approval Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($linkages as $linkage)
                                <tr>
                                    <td class="text-center">
                                        @if(Auth::user()->hasRole('College Super Admin'))
                                            @if($linkage->approval_status == "Pending")
                                                <form action="university-industry-linkage/{{$linkage->id}}/approve"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="disapprove">
                                                    <button type="submit" style="opacity:0.80" data-toggle="tooltip"
                                                            title="Disapprove"
                                                            class="btn btn-danger btn-circle text-white btn-sm">
                                                        <i class="fas fa-times" style="opacity:0.75"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if($linkage->approval_status != "Approved")
                                                <div class="row px-0">
                                                    <div class="col px-0">
                                                        <form class="p-0"
                                                              action="/student/university-industry-linkage/{{$linkage->id}}/edit"
                                                              method="GET">
                                                            <button type="submit"
                                                                    class="btn btn-primary btn-circle text-white btn-sm"
                                                                    style="opacity:0.80" data-toggle="tooltip"
                                                                    title="Edit">
                                                                <i class="fas fa-pencil-alt fa-sm"
                                                                   style="opacity:0.75"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col px-0">
                                                        <button type="submit"
                                                                class="btn btn-danger btn-circle text-white btn-sm mx-0 deleter"
                                                                style="opacity:0.80" data-id="{{$linkage->id}}"
                                                                data-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash fa-sm"
                                                               style="opacity:0.75"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $linkage->year}}</td>
                                    <td>{{ $linkage->number_of_industry_links }}</td>
                                    <td>{{ $linkage->training_area }}</td>
                                    <td>{{ $linkage->number_of_students }}</td>
                                    @if($linkage->approval_status == "Approved")
                                        <td class="text-success"><i
                                                    class="fas fa-check"></i> {{$linkage->approval_status}}</td>
                                    @elseif($linkage->approval_status == "Pending")
                                        <td class="text-warning"><i
                                                    class="far fa-clock"></i></i> {{$linkage->approval_status}}</td>
                                    @else
                                        <td class="text-danger"><i
                                                    class="fas fa-times"></i> {{$linkage->approval_status}}</td>
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

    @if ($page_name == 'students.university_industry_linkage.create')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="pb-5" action="/student/university-industry-linkage" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTitle">Add</h5>
                            <a href="/student/university-industry-linkage" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>

                        <div class="modal-body pt-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="year" id="year">
                                        @foreach ($years as $key => $value)
                                            <option value="{{$key}}" {{ (old('year') == $key ? 'selected':'') }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="year" class="form-control-placeholder">
                                        Year Level
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="industry_number" name="industry_number"
                                           value="{{ old('industry_number') }}"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="industry_number">Linked
                                        Industries</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="training_area" name="training_area" class="form-control"
                                           value="{{ old('training_area') }}"
                                           required>
                                    <label class="form-control-placeholder" for="training_area">Training Area</label>
                                </div>
                                <div class="col form-group">
                                    <input type="number" id="number_of_students" name="number_of_students"
                                           value="{{ old('number_of_students') }}"
                                           class="form-control" required>
                                    <label class="form-control-placeholder" for="number_of_students">Number of
                                        Students</label>
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


    @if ($page_name == 'students.university_industry_linkage.edit')
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form class="pb-5" action="/student/university-industry-linkage/{{$id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTitle">Edit</h5>
                            <a href="/student/university-industry-linkage" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>

                        <div class="modal-body pt-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    {{-- <select class="form-control" name="year" id="year">
                                        @foreach ($years as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="year" class="form-control-placeholder">
                                        Year Level
                                    </label> --}}

                                    <label class="label" for="year">Year Level</label>
                                    <input type="text" id="year" class="form-control"
                                           disabled value="{{$year}}">
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="industry_number" name="industry_number"
                                           class="form-control"
                                           required value="{{$number_of_linked_indutries}}">
                                    <label class="form-control-placeholder" for="industry_number">Linked
                                        Industries</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="training_area" name="training_area" class="form-control"
                                           required value="{{$training_area}}">
                                    <label class="form-control-placeholder" for="training_area">Training Area</label>
                                </div>
                                <div class="col form-group">
                                    <input type="number" id="number_of_students" name="number_of_students"
                                           class="form-control" required value="{{$number_of_students}}">
                                    <label class="form-control-placeholder" for="number_of_students">Number of
                                        Students</label>
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

@endSection
