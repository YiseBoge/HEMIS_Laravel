@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/staff/technical" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Technical Staff Member</h3>
            <fieldset id="academic-staff" class="card shadow">
                <div class="card-header text-primary">
                    Technical Staff Information
                </div>
                <div class="card-body px-5">
                    <div class="form-row pt-3">
                        <div class="col-7 form-group">
                            <select class="form-control" id="staff" name="staff">
                                @foreach (array("name", "name") as $value)
                                    <option value="{{$value}}" {{ (old('staff') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="staff" class="form-control-placeholder">Staff</label>
                        </div>
                         <div class="col-3 form-group">
                            <select class="form-control" id="job_title" name="job_title">
                                @foreach (array("Lecturer", "Assistant Lecturer") as $value)
                                    <option value="{{$value}}" {{ (old('job_title') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="job_title" class="form-control-placeholder">Job Title</label>
                        </div>
                         <div class="col-2 form-group">
                            <select class="form-control" id="job_level" name="job_level">
                                @foreach (array("1", "2") as $value)
                                    <option value="{{$value}}" {{ (old('job_level') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label for="job_level" class="form-control-placeholder">Level</label>
                        </div>
                    </div>
                    <div class="form-row pt-3">
                        <div class="col form-group">
                            <textarea class="form-control" id="additional_remarks" name="additional_remark"
                                      rows="3">{{ old('additional_remarks') }}</textarea>
                            <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection
