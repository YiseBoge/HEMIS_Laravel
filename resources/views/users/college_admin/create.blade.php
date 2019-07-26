@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header text-primary">{{ Auth::user()->hasRole('University Admin') ? 'Add College Super Admin' : 'Add Administerer Admin' }}</div>
                    <div class="card-body pt-4">
                        {!! Form::open(['action' => 'User\CollegeAdminController@store', 'method' => 'POST']) !!}

                        <div class="form-group row {{(Auth::user()->hasRole('University Admin') ? '' : 'd-none')}}">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('College') }}</label>
                            <div class="col-md-6">
                                {!! Form::select('college_name_id', $college_names, Auth::user()->hasRole('University Admin') ? old('college_name_id') : $college_name  , ['class' => 'form-control']) !!}
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                {{ Form::hidden('role', (Auth::user()->hasRole('University Admin') ? 'College Super Admin' : 'College Admin'), ['id' => 'id']) }}
                                {!! Form::submit('Add Admin', ['class' => 'btn btn-primary btn-sm']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
