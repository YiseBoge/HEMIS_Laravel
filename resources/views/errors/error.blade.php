@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="error mx-auto" data-text="Error">Error</div>
        <p class="lead text-gray-800 mb-5">Oops</p>
        <p class="text-gray-500">Something went wrong.</p>
        <a href="{{\Illuminate\Support\Facades\URL::previous()}}">← Go Back</a>
    </div>
@endsection