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
        <form class="pb-5" action="/department/publication/{{$id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="publication" value="true">
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Edit Staff Publication Information
                            <button class="btn btn-outline-warning float-right" type="submit"><i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col-md form-group">
                                    <label class="label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           required value="{{$title}}">
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col-md-6 form-group">
                                    <label class="label" for="author">Author</label>
                                    <input type="text" id="author" name="author" class="form-control"
                                           disabled value="{{$author}}">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" id="date" name="date" type="date"
                                               value="{{$date}}">
                                        <label for="date" class="form-control-placeholder">Date of Publication</label>
                                    </div>
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

