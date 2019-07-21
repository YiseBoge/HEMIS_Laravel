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
        <form class="pb-5" action="/department/teachers/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Teachers Information
                            <button class="btn btn-outline-warning float-right" type="submit"> <i class="fa fa-save"></i> Save</button>
                        </div>
                        <div class="card-body px-4">

                            <div class="form-group row pt-3">


                                <div class="col-md-6 form-group">
                                    {{-- <select class="form-control" name="education_level" id="education_level">
                                        @foreach ($education_levels as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <label for="education_level" class="form-control-placeholder">
                                        Education Level
                                    </label> --}}

                                    <label class="label" for="education_level">Education Level</label>
                                    <input type="text" id="education_level" class="form-control"
                                           disabled value="{{$education_level}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="label" for="citizenship">Citizenship</label>
                                    <input type="text" id="citizenship" class="form-control"
                                           disabled value="{{$citizenship}}">
                                </div>
                            </div>


                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="male_number" name="male_number" class="form-control"
                                           required value="{{$male_number}}">
                                    <label class="form-control-placeholder" for="male_number">Male
                                        Teachers</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="female_number" name="female_number" class="form-control"
                                           required value="{{$female_number}}">
                                    <label class="form-control-placeholder" for="female_number">Female
                                        Teachers</label>
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

