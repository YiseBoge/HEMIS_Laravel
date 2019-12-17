@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/staff/management" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Management Staff Member</h3>

            <fieldset id="academic-staff" class="card shadow">
                <div class="card-header text-primary">
                    Management Staff Information
                </div>
                <div class="card-body px-5">
                    <div class="form-row pt-3">
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="staff" name="staff_type"
                                    onchange="this.options[this.selectedIndex].value && (window.location = '{{Request::url()}}?staff_type=' + this.options[this.selectedIndex].value)">
                                @foreach (array("Administrative", "Academic") as $value)
                                    <option value="{{$value}}" {{ $staff_type == $value ? 'selected':'' }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="staff" class="form-control-placeholder">Staff Type</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="staff" name="staff">
                                @foreach ($staffs as $value)
                                    <option value="{{$value->general->id}}" {{ (old('staff') == $value ? 'selected':'') }}>
                                        {{$value->general->name}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="staff" class="form-control-placeholder">Staff</label>
                        </div>
                    </div>

                    <div class="form-row pt-3">
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="management_level" name="management_level">
                                @foreach ($levels as $key => $value)
                                    <option value="{{$key}}" {{ (old('management_level') == $key ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="management_level" class="form-control-placeholder">Management Level</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="job_title" name="job_title">
                                @foreach ($job_titles as $value)
                                    <option value="{{$value->id}}" {{ (old('job_title') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-control-placeholder" for="job_title">Job Title</label>
                        </div>
                    </div>
                    {{--                    <div class="form-row pt-3">--}}
                    {{--                        <div class="col form-group">--}}
                    {{--                            <textarea class="form-control" id="additional_remarks" name="additional_remark"--}}
                    {{--                                      rows="3">{{ old('additional_remark') }}</textarea>--}}
                    {{--                            <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </fieldset>
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection