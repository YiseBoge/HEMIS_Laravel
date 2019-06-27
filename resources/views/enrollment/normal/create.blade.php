@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <!--  Disabled Students Form  -->
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form class="pb-5" action="/enrollment/normal" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Enrollment
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="student_type" id="student_type">
                                        @foreach ($student_types as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="student_type" class="form-control-placeholder">
                                        Student Type
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">

                                    <select class="form-control" name="program" id="program">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="program" class="form-control-placeholder">
                                        Program
                                    </label>
                                </div>

                                <div class="col-md-5 form-group">

                                    <select class="form-control" name="education_level" id="level">
                                        @foreach ($education_levels as $key => $value)
                                            @if ($key == 'SPECIALIZATION')
                                                <option disabled value="{{$key}}">{{$value}}</option>
                                            @else
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="level" class="form-control-placeholder">
                                        Education Level
                                    </label>
                                </div>
                                <div class="col-md-3 form-group">

                                    <select class="form-control" name="year_level" id="year_level">
                                        @foreach ($year_levels as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
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
                                           required>
                                    <label class="form-control-placeholder" for="male_number">Male
                                        Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Students</label>
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

