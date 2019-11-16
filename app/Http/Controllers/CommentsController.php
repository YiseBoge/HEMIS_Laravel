<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');

        $comments = Comment::paginate();

        $data = array(
            'comments' => $comments,
            'page_name' => 'comment.comment.index',
        );

        return view('comments.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'page_name' => 'comment.comment.create',
        );

        return view('comments.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

       $comment = new Comment;

       $comment->name = $request->input('name');
       $comment->email = $request->input('email');
       $comment->message = $request->input('message');
       $comment->user_id = $request->input('user_id');

       $comment->save();

        return redirect('/comments/create')->with('primary', 'Successfully submitted feedback.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user == null) return redirect('/login');

        $comment = Comment::find($id);
        $comment->delete();
        return redirect('/comments')->with('primary' , 'Successfully deleted a comment');
    }
}
