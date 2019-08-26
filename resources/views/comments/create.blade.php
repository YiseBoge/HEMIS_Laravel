@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4  col-sm-6 col-md-5 col-xs-12">
        <form action="{{action('CommentsController@store')}}" method="POST">
            @csrf
            @if(Auth::user() != null && Auth::user()->hasAnyRole(['Department Admin' , 'College Admin' , 'College Super Admin' , 'University Admin' , 'Super Admin']))
                <input type="text" hidden
                value="{{Auth::user()->id}}" name="user_id" id="user_id">
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 text-center">
                            @include('inc.messages')
                        </div>
                        <div class="col-12">
                            <span class="lead float-left px-2">Contact Us</span>
                            @if(Auth::user() != null && Auth::user()->hasAnyRole(['Department Admin' , 'College Admin' , 'College Super Admin' , 'University Admin' , 'Super Admin']))
                                <span class="float-right">
                                    <button class="btn"><a href="/comments">View Comments</a></button>
                                </span>
                            @endif
                        </div>
                    </div>
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
                                    name="email" value="{{ old('email') }}" required autofocus>

                            <label for="email" class="form-control-placeholder">
                                {{ __('Email Address') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md mb-3"> 
                            <textarea class="form-control" id="message"
                             name="message" placeholder="Please enter your message here" rows="3" required>{{old('message')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn float-left"><a class="" href="/">Cancel</a></button>
                        </div>

                        <div class="col-6">
                            <button type="submit" class="btn btn-primary float-right">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection