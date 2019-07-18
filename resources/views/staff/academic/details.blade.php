@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row">
            <div class="col-md-10">
                <h1 class="font-weight-bold text-primary">Academic Staff</h1>
            </div>
            <div class="col-md-2 pt-4">
                <a href="{{$staff->id}}/edit" class="text-primary mr-3"><i class="far fa-edit"></i> Edit</a>
                <a href="" class="d-inline text-danger" data-toggle="modal"
                   data-target="#deleteModal"><i class="far fa-trash-alt"></i> Delete
                </a>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                <div class="mb-0 text-gray-800">{{$staff->general->name}}</div>
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                <div class="mb-0 text-gray-800">{{$staff->general->sex}}</div>

                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Nationality</div>
                                <div class="mb-0 text-gray-800">{{$staff->general->nationality}}</div>
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone Number
                                </div>
                                <div class="mb-0 text-gray-800">{{$staff->general->phone_number}}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of Birth
                                </div>
                                <div class="mb-0 text-gray-800">{{$staff->general->birth_date}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Place of Origin Information
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Is Expatriate</div>
                        @if ($staff->general->is_expatriate == 0)
                            <p>No</p>
                        @else
                            <p>Yes</p>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Is From Region Other that the Host Region</div>
                        @if ($staff->general->is_from_other_region == 0)
                            <p>No</p>
                        @else
                            <p>Yes</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Employment Information
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                        <p>{{$staff->general->job_title}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dedication</div>
                        <p>{{$staff->general->dedication}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Employment Type</div>
                        <p>{{$staff->general->employment_type}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                        @if ($staff->staff_leave_id == 0)
                            <p>On Duty</p>
                        @else
                            <p>On Study Leave</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Academic Level</div>
                        <p>{{$staff->general->academic_level}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Salary</div>
                        <p>{{$staff->general->salary}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years of Service</div>
                        <p>{{$staff->general->service_year}}</p>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Academic Staff Information
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                        <p>{{$staff->staffRank}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Field of Study</div>
                        <p>{{$staff->field_of_study}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Teaching Load</div>
                        <p>{{$staff->teaching_load}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Reason for Overload
                        </div>
                        <p>{{$staff->overload_remark}}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($staff->staff_leave_id != 0)
            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Leave Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Leave Type</div>
                            <p>{{$staff->staffLeave->leave_type}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Country</div>
                            <p>{{$staff->staffLeave->country_of_study}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Institution</div>
                            <p>{{$staff->staffLeave->institution}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Status</div>
                            <p>{{$staff->staffLeave->status_of_study}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Rank</div>
                            <p>{{$staff->staffLeave->rank_of_study}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Scholarship</div>
                            <p>{{$staff->staffLeave->scholarship_type}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="card shadow mt-3">
            <div class="card-header text-primary">
                Remarks
            </div>
            <div class="card-body">
                <p>{{$staff->general->remarks}}</p>
            </div>
        </div>

    </div>

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
                    <form action="/staff/academic/{{$staff->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="form-control btn btn-danger">
                            <i class="far fa-trash-alt"></i> Delete
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
