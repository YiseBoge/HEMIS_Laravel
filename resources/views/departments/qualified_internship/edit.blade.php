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
        <form class="pb-5" action="/student/qualified-internship/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                           Qualified Internship
                        </div>
                        <div class="card-body px-4">

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <label class="label" for="action">Sponsor Type</label>
                                    <input type="text" id="action" class="form-control"
                                           disabled value="{{$type}}">
                                </div>
                                <div class="col form-group">
                                    <label class="label" for="male_number">Male Number</label>
                                    <input type="number" id="male_number" name="male_number"
                                           class="form-control"
                                           required value="{{$male_number}}">
                                </div>

                                <div class="col form-group">
                                    <label class="label" for="female_number">Female Number</label>
                                    <input type="number" id="female_number" name="female_number"
                                           class="form-control"
                                           required value="{{$female_number}}">
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

