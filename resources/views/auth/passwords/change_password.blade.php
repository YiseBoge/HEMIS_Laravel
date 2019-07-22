@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 px-md-3">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header text-primary">Change Password</div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('changePassword') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="current-password" class="col-md-4 col-form-label text-md-right">Current
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password"
                                           class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}"
                                           name="current-password" required value="{{ old('current-password') }}">

                                    @if ($errors->has('current-password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password" class="col-md-4 col-form-label text-md-right">New
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password"
                                           class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}"
                                           name="new-password" required value="{{ old('new-password') }}">

                                    @if ($errors->has('new-password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                                    New Password</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                           name="new-password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
