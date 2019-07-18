@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/enrollment/special-region-students" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Special Regions Enrollment
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="region_type" id="region_type">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$key}}" {{ (old('region_type') == $key ? 'selected':'') }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="region_type" class="form-control-placeholder">
                                        Region Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="region" id="region">
                                        @foreach ($regions as $region)
                                            <option value="{{$region->name}}" {{ (old('region') == $region->name ? 'selected':'') }}>{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="region" class="form-control-placeholder">
                                        Region
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="education_level" id="level">
                                        @foreach ($education_levels as $key => $value)
                                            @if ($key == 'SPECIALIZATION')
                                                <option disabled
                                                        value="{{$key}}" {{ (old('education_level') == $key ? 'selected':'') }}>{{$value}}</option>
                                            @else
                                                <option value="{{$key}}" {{ (old('education_level') == $key ? 'selected':'') }}>{{$value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="level" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                                <div class="col-md-4 form-group">

                                    <select class="form-control" name="program" id="program">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$key}}" {{ (old('program') == $key ? 'selected':'') }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="program" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col-md-4 form-group">

                                    <select class="form-control" name="year_level" id="year_level">
                                        @foreach ($year_levels as $key => $value)
                                            <option value="{{$key}}" {{ (old('year_level') == $key ? 'selected':'') }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="year_level" class="form-control-placeholder">
                                        Year Level
                                    </label>
                                </div>

                            </div>
                            <hr>

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value=“{{ old('male_number') }}">
                                    <label class="form-control-placeholder" for="male_number">Male Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required value=“{{ old('female_number') }}">
                                    <label class="form-control-placeholder" for="female_number">Female Students</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

