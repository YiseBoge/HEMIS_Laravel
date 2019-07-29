@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form class="pb-5" action="/enrollment/specializing-students/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Specializing Students Enrollment Information
                            <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <label class="label" for="student_type">Student Type</label>
                                    <input type="text" id="student_type" class="form-control" name="student_type"
                                           disabled value="{{$student_type}}">
                                </div>
                                <div class="col form-group">
                                    <label class="label" for="specialization_type">Specialization Type</label>
                                    <input type="text" id="specialization_type" class="form-control"
                                           disabled value="{{$specialization_type}}">
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-md-4 form-group">
                                    <label class="label" for="program">Program</label>
                                    <input type="text" id="program" class="form-control"
                                           disabled value="{{$program}}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="label" for="year_level">Year Level</label>
                                    <input type="text" id="year_level" class="form-control"
                                           disabled value="{{$year_level}}">
                                </div>
                                <div class="col form-group">
                                    <label class="label" for="specialization_field">Field of Specialization</label>
                                    <input type="text" id="specialization_field" class="form-control"
                                           disabled value="{{$field_of_specialization}}">
                                </div>

                            </div>
                            <hr>

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value="{{$male_students_number}}">
                                    <label class="form-control-placeholder" for="male_number">Male
                                        Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required value="{{$female_students_number}}">
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
