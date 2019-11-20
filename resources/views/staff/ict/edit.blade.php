@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <form action="/staff/ict/{{$staff->id}}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="font-weight-bold text-primary">ICT Staff</h1>
                </div>
                <div class="col-md-3 pt-3">
                    <button type="submit" class="form-control form-control-plaintext text-primary">
                        <i class="far fa-save mr-2"></i> Save
                    </button>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header text-primary">
                    ICT Staff Information
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="text-sm font-weight-bold text-gray-900 text-uppercase mb-1">Job Title</div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-0"><i
                                                class="text-gray-400 float-right far fa-edit "></i></span>
                                </div>
                                <select class="form-control form-control-plaintext" name="ict_type">
                                    @foreach ($ict_types as $value)
                                        @if ($value->id == $staff->staff_type_id)
                                            <option selected value="{{$value->id}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value->id}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
