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
        <form class="pb-5" action="/enrollment/special-region-students/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Special Regions Enrollment Information
                            <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <label class="label" for="region_type">Region Type</label>
                                    <input type="text" id="region_type" name="region_type" class="form-control"
                                           value="{{$type}}" disabled>
                                </div>
                                <div class="col form-group">
                                    <label class="label" for="region">Region</label>
                                    <input type="text" id="region" name="region" class="form-control"
                                           value="{{$region}}" disabled>
                                </div>
                                <div class="col form-group">
                                    <label class="label" for="student_type">Student Type</label>
                                    <input type="text" id="student_type" name="student_type" class="form-control"
                                           value="{{$student_type}}" disabled>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">
                                    <label class="label" for="education_level">Education Level</label>
                                    <input type="text" id="education_level" name="education_level" class="form-control"
                                           value="{{$education_level}}" disabled>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="label" for="program">Program</label>
                                    <input type="text" id="program" name="program" class="form-control"
                                           value="{{$program}}" disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label class="label" for="year_levl">Year Level</label>
                                    <input type="text" id="year_levl" name="year_levl" class="form-control"
                                           value="{{$year_level}}" disabled>
                                </div>

                            </div>
                            <hr>

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value="{{$male_number}}">
                                    <label class="form-control-placeholder" for="male_number">Male
                                        Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required value="{{$female_number}}">
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Students</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            {{-- <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit"> --}}
        </form>
    </div>
@endsection

