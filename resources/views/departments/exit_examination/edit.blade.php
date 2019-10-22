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
        <form class="pb-5" action="/student/exit-examination/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Students that Passed Graduates Exit Examination Information
                            <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="number" id="males_sat" name="males_sat" class="form-control"
                                           required value="{{ $exit_examination->males_sat }}">
                                    <label class="form-control-placeholder" for="males_sat">Males who Sat</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="females_sat" name="females_sat" class="form-control"
                                           required value="{{ $exit_examination->females_sat }}">
                                    <label class="form-control-placeholder" for="females_sat">Females who Sat</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col form-group">
                                    <input type="number" id="males_passed" name="males_passed" class="form-control"
                                           required value="{{$exit_examination->males_passed}}">
                                    <label class="form-control-placeholder" for="males_passed">Males who Passed</label>
                                </div>

                                <div class="col form-group">
                                    <input type="number" id="females_passed" name="females_passed" class="form-control"
                                           required value="{{ $exit_examination->females_passed }}">
                                    <label class="form-control-placeholder" for="females_passed">Females who
                                        Passed</label>
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

