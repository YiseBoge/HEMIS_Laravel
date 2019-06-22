@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form action="/staff/management/{{$staff->id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="font-weight-bold text-primary">Management Staff</h1>
                </div>
                <div class="col-md-3 pt-3">
                    <button type="submit" class="form-control form-control-plaintext text-primary">
                        <i class="far fa-save mr-2"></i></i> Save
                    </button>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-12">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="name"
                                               value="{{$staff->general->name}}">

                                    </div>
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Sex</div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="sex"
                                               value="{{$staff->general->sex}}">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Nationality
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext"
                                               name="nationality" value="{{$staff->general->nationality}}">
                                    </div>
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Phone
                                        Number
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext"
                                               name="phone_number" value="{{$staff->general->phone_number}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Date of
                                        Birth
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0"><i
                                                        class="text-gray-400 float-right far fa-edit "></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-plaintext" name="birth_date"
                                               value="{{$staff->general->birth_date}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header text-primary">
                    Employment Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="job_title"
                                       value="{{$staff->general->job_title}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Dedication</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="dedication">
                                    @foreach ($staff->general->getEnum("Dedications") as $key => $value)
                                        @if ($value == $staff->general->dedication)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Employment Type
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="employment_type">
                                    @foreach ($staff->general->getEnum("EmploymentTypes") as $key => $value)
                                        @if ($value == $staff->general->employment_type)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Academic Level</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="academic_level">
                                    @foreach ($staff->general->getEnum("AcademicLevels") as $key => $value)
                                        @if ($value == $staff->general->academic_level)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Salary</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="salary"
                                       value="{{$staff->general->salary}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Years of Service
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <input type="text" class="form-control form-control-plaintext" name="service_year"
                                       value="{{$staff->general->service_year}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Is Expatriate</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="expatriate">
                                    @if ($staff->general->is_expatriate == 0)
                                        <option value="1">Yes</option>
                                        <option selected value="0">No</option>
                                    @else
                                        <option selected value="1">Yes</option>
                                        <option value="0">No</option>
                                    @endif

                                </select>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Management Staff Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Management Level
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="management_level">
                                    @foreach ($staff->getEnum("ManagementLevels") as $key => $value)
                                        @if ($value == $staff->management_level)
                                            <option selected value="{{$key}}">{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    Remarks
                </div>
                <div class="card-body">
                    <textarea class="form-control" id="additional_remarks" name="additional_remark"
                              rows="3">{{$staff->general->remarks}}</textarea>
                </div>

            </div>

        </form>
    </div>
@endsection
