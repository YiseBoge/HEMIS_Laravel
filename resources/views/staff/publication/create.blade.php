@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form class="pb-5" action="/department/publication" method="POST">
            @csrf
            <div class="row my-5">
                <div class="col">
                    <fieldset class="card shadow h-100">
                        <div class="card-header text-primary">
                            Staff Publications
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group row pt-3">
                                <div class="col-md form-group">
                                    <input type="text" id="title" name="title" class="form-control"
                                           value="{{ old('title') }}"
                                           required>
                                    <label class="form-control-placeholder" for="title">Title</label>
                                </div>
                            </div>
                            <div class="form-group row pt-3">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="staff" id="staff">
                                        @foreach ($staffs as $staff)
                                            <option value="{{$staff->id}}" {{ (old('staff') == $staff->id ? 'selected':'') }}>
                                                {{$staff->general->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="staff" class="form-control-placeholder">
                                        Author
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" id="date" name="date" type="date"
                                               value="{{ old('date') }}"
                                               placeholder="2011-08-19">
                                        <label for="date" class="form-control-placeholder">Date of Publication</label>
                                    </div>
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

