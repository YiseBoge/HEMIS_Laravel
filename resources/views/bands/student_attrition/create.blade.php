@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--  Disabled Students Form  -->
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <form class="pb-5" action="/institution/student-attrition" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Student Attrition
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="band" id="band">
                                        @foreach ($bands as $band)
                                            <option value="{{$band->band_name}}">{{$band->band_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="band" class="form-control-placeholder">
                                        Band
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="program" id="program">
                                        @foreach ($programs as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="program" class="form-control-placeholder">
                                        Education Program
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <select class="form-control" name="type" id="type">
                                        @foreach ($types as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="type" class="form-control-placeholder">
                                        Type
                                    </label>
                                </div>
                                <div class="col form-group">
                                    <select class="form-control" name="case" id="case">
                                        @foreach ($cases as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="case" class="form-control-placeholder">
                                        Case
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="male_number" name="male_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="male_number">Number of Male
                                        Students</label>
                                </div>

                                <div class="col form-group">
                                    <input type="text" id="female_number" name="female_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="female_number">Number of Female
                                        Students</label>
                                </div>

                            </div>
                        </div>
                </div>
                </fieldset>
            </div>

            <input type="submit" class="btn btn-outline-secondary float-right my-1" value="Submit">
        </form>
    </div>
@endsection

