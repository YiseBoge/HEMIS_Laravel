@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="error mx-auto" data-text="401">404</div>
        <p class="lead text-gray-800 mb-5">Unauthorized Action</p>
        <p class="text-gray-500 mb-0">Sorry but you are not allowed here...</p>
        <a href="/">← Back to Home</a>
    </div>
@endsection
