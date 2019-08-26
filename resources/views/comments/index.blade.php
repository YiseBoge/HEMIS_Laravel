@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card my-4 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            @include('inc.messages')
                        </div>
                        <div class="col-12">
                            <span class="lead float-left px-2">Comments</span>
                        </div>
                    </div>
                    @forelse($comments as $comment)
                        <div class="card my-3 {{($comment->user_id != null) ? 'border-left-danger' : ''}}">
                            <div class="card-body m-0 py-2">
                                    <div class="row">
                                        <div class="col-12">
                                                <span class="flaot-left">{{$comment->name}} : </span>
                                                @if(Auth::user()->hasRole('Super Admin'))
                                                    <span class="float-right">
                                                        <form action="/comments/{{$comment->id}}/" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn p-0 m-0 text-danger" type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </span>
                                                @endif
                                        </div>
                                        <div class="col-12 lead my-3"> {{$comment->message}}
                                        </div>

                                        <div class="col-12 mb-0 pb-0" >
                                            <span class="float-left">
                                                <small>{{$comment->email}}</small>
                                            </span>
            
                                            <span class="float-right">
                                                <small>{{$comment->created_at->format('M d Y | H:00')}}</small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            {{-- </a> --}}
                        </div>
                    @empty
                        <div class="text-center">
                            <span class="text-danger lead p-4">No Comments yet</span>
                        </div>
                    @endforelse
                </div>
            </div>
    </div>
</div>

<div class="row justify-centent-center py-3">
    <div class="col-12 text-center justify-content-center">
        {{$comments->links()}}
    </div>
</div>
@endsection