@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <form action="{{action('CommentsController@store')}}" method="POST">
            @csrf
            @if(Auth::user() != null && Auth::user()->hasAnyRole(['Department Admin' , 'College Admin' , 'College Super Admin' , 'University Admin' , 'Super Admin']))
                <input type="text" hidden
                value="{{Auth::user()->id}}" name="user_id" id="user_id">
            @endif
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Give Feedback

                        @if(Auth::user() != null && Auth::user()->hasAnyRole(['Department Admin' , 'College Admin' , 'College Super Admin' , 'University Admin' , 'Super Admin']))
                            <span class="float-right">
                                    <a href="/comments">View Submitted</a>
                                </span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md">
                            <input type="text" class="form-control " id="name" 
                            name="name" required value="{{old('name')}}">
                            <label for="name" class="form-control-placeholder">
                                {{ __('Name') }}
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md my-3">
                            <input id="email" type="email"
                                   class="form-control"
                                   name="email" value="{{ old('email') }}" required>

                            <label for="email" class="form-control-placeholder">
                                {{ __('Email Address') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md my-3">
                            <textarea class="form-control" id="message"
                                      name="message" rows="3" required>{{old('message')}}</textarea>

                            <label for="message" class="form-control-placeholder">
                                {{ __('Message') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn float-left"><a class="" href="/">Cancel</a></button>
                        </div>

                        <div class="col-6">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection