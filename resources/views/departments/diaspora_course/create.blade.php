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
        <form class="pb-5" action="/department/diaspora-courses" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Courses/Modules Taught and Postgraduate Researches Advised by Ethiopian Diaspora
                        </div>
                        <div class="card-body px-4">

                            <div class="form-group row pt-3">
                                <div class="col form-group">
                                    <input type="text" id="course_number" name="course_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="course_number">Number of
                                        Courses/Modules</label>
                                </div>

                                <div class="col form-group">
                                    <input type="text" id="research_number" name="research_number" class="form-control"
                                           required>
                                    <label class="form-control-placeholder" for="research_number">Number of
                                        Researches</label>
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

