@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/staff/administrative" method="POST">
            @csrf
            <h3 class="font-weight-bold text-primary">Add Administrative Staff Member</h3>
            <div class="row my-5">
                <div class="col-md-5">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Personal Information
                        </div>
                        <div class="card-body px-4">
                            <div class="form-row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="name" name="name" class="form-control" required
                                           value="{{ old('name') }}">
                                    <label class="form-control-placeholder" for="name">Full Name</label>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" id="bdate" name="birth_date" type="date"
                                               value="{{ old('birth_date') }}"
                                               placeholder="2011-08-19">
                                        <label for="bdate" class="form-control-placeholder">Date of Birth</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div id="sex">
                                            <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                               name="sex" value="Male"
                                                                               {{ old('sex')=='Male' ? 'checked='.'"'.'checked'.'"' : '' }}
                                                                               id="male">Male</label>
                                            <label class="radio-inline"><input class="form-check-inline" type="radio"
                                                                               {{ old('sex')=='Female' ? 'checked='.'"'.'checked'.'"' : '' }}
                                                                               name="sex" value="Female">Female</label>
                                        </div>
                                        <!--<label class="form-control-placeholder" for="male">Sex</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="tel" id="phoneno" name="phone_number" class="form-control"
                                               value="{{ old('phone_number') }}"
                                               required>
                                        <label class="form-control-placeholder" for="phoneno">Phone Number</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @include('inc.country_select', ['name' => 'nationality', 'default' => old('nationality')])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-7">
                    <fieldset class="card shadow mt-md-0 mt-5 h-100">
                        <div class="card-header text-primary">
                            Employment Information
                        </div>
                        <div class="card-body px-5">
                            <div class="form-row pt-3">
                                <div class="col-md form-group">
                                    <input type="number" id="salary" name="salary" class="form-control" required
                                           value="{{ old('salary') }}">
                                    <label class="form-control-placeholder" for="salary">Salary</label>
                                </div>
                                <div class="col-md form-group">
                                    <input type="number" id="service_year" name="service_year" class="form-control"
                                           value="{{ old('service_year') }}"
                                           required>
                                    <label class="form-control-placeholder" for="service_year">Service Year</label>
                                </div>
                            </div>

                            <div class="form-row pt-3">
                                <div class="col-md form-group">

                                    <select class="form-control" id="empType" name="employment_type">
                                        @foreach ($employment_types as $key => $value)
                                            <option value="{{$key}}" {{ (old('employment_type') == $key ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="empType" class="form-control-placeholder">Employment Type</label>
                                </div>

                                <div class="col-md form-group">

                                    <select class="form-control" id="dedication" name="dedication">
                                        @foreach ($dedications as $key => $value)
                                            <option value="{{$key}}" {{ (old('dedication') == $key ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="dedication" class="form-control-placeholder">Dedication</label>
                                </div>

                                <div class="col-md form-group">

                                    <select class="form-control" id="academic-level" name="academic_level"
                                            data-live-search="true">
                                        @foreach ($academic_levels as $key => $value)
                                            <option value="{{$key}}" {{ (old('academic_level') == $key ? 'selected':'') }}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="academic-level" class="form-control-placeholder">Academic Level</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group form-check">
                                    <input class="form-check-input" id="expatriate" name="expatriate" type="checkbox"
                                           {{ (! empty(old('expatriate')) ? 'checked' : '') }}
                                           value="expatriate">
                                    <label class="form-check-label" for="expatriate">Expatriate</label>
                                </div>
                                <div class="col-md-8 form-group form-check">
                                    <input class="form-check-input" id="other_region" name="other_region"
                                           {{ (! empty(old('other_region')) ? 'checked' : '') }}
                                           type="checkbox" value="expatriate">
                                    <label class="form-check-label" for="other_region">From Region Other than the Host
                                        Region</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <fieldset id="academic-staff" class="card shadow">
                <div class="card-header text-primary">
                    Administrative Staff Information
                </div>
                <div class="card-body px-5">
                    <div class="form-row pt-3">
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="job_title" name="job_title">
                                @foreach (
                                array('Lecturer', 'Assistant Lecturer') as $value)
                                    <option value="{{$value}}" {{ (old('job_title') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-control-placeholder" for="job_title">Job Title</label>
                        </div>
                        <div class="col-md-6 form-group">
                            <select class="form-control" id="job_level" name="job_level">
                                @foreach (
                                array('1', '1') as $value)
                                    <option value="{{$value}}" {{ (old('job_level') == $value ? 'selected':'') }}>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-control-placeholder" for="job_title">Level</label>
                        </div>
                    </div>
                    <div class="form-row pt-3">
                        <div class="col form-group">
                            <textarea class="form-control" id="additional_remarks" name="additional_remark"
                                      rows="3">{{ old('additional_remark') }}</textarea>
                            <label for="additional_remarks" class="form-control-placeholder">Additional Remarks</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <button class="btn btn-outline-secondary float-right my-1" type="submit">Submit</button>
        </form>
    </div>
@endsection
