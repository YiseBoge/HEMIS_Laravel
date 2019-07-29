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
        <form class="pb-5" action="/enrollment/age-enrollment/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Enrollment Information
                            <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col-md form-group">

                                    <label class="label" for="age_range">Age Range</label>
                                    <input type="text" id="age_range" class="form-control"
                                           disabled value="{{$age_range}}">
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">
                                    <label class="label" for="program">Program</label>
                                    <input type="text" id="program" class="form-control"
                                           disabled value="{{$program}}">
                                </div>

                                <div class="col-md-5 form-group">
                                    <label class="label" for="education_level">Education Level</label>
                                    <input type="text" id="education_level" class="form-control"
                                           disabled value="{{$education_level}}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="label" for="year_level">Year Level</label>
                                    <input type="text" id="year_level" class="form-control"
                                           disabled value="{{$year_level}}">
                                </div>

                            </div>
                            <hr>

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="number_of_males" name="number_of_males"
                                           class="form-control"
                                           required value="{{$male_students_number}}">
                                    <label class="form-control-placeholder" for="number_of_males">Male
                                        Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="number_of_females" name="number_of_females"
                                           class="form-control" required value="{{$female_students_number}}">
                                    <label class="form-control-placeholder" for="number_of_females">Female
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

