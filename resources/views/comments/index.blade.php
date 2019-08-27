@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Feedback</h6>
            </div>
            <div class="card-body">
                    @forelse($comments as $comment)
                    <div class="card shadow-sm my-4 {{($comment->user_id != null) ? 'border-left-danger' : ''}}">
                            <div class="card-body m-0 py-2">
                                    <div class="row">
                                        <div class="col-12">
                                                <span class="flaot-left">{{$comment->name}} : </span>
                                                @if(Auth::user()->hasRole('Super Admin'))

                                                <button type="submit"
                                                        class="btn btn-danger btn-circle float-right text-white btn-sm mx-0 deleter"
                                                        style="opacity:0.80" data-id="{{$comment->id}}"
                                                        data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash fa-sm"
                                                       style="opacity:0.75"></i>
                                                </button>
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