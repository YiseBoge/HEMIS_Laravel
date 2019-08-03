@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Not Found</p>
        <p class="text-gray-500">It looks like the requested couldn't be found</p>
        <a href="{{\Illuminate\Support\Facades\URL::previous()}}">← Go Back</a>
    </div>
@endsection
