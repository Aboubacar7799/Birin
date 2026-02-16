<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string|max:2000']);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        //création de notification après le like d'un post
        if ($post->user_id !== auth()->id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'comment',
                'notifiable_id' => $post->id,
                'notifiable_type' => Post::class,
            ]);
        }

        return response()->json([
            'username' => auth()->user()->name,
            'content' => $request->content
        ]);
    }

    // public function edit(Request $request, Comment $comments)
    // {

    //     return view('posts.comments.edit', compact('comments'));
    // }

    // public function update(Request $request, Comment $comments)
    // {

    //     $request->validate(['content' => 'required|string|max:2000']);

    //     $comments->comments()->update([
    //         'user_id' => auth()->id(),
    //         'content' => $request->content
    //     ]);

    //     return redirect()->route('comments.store', ['comments' => $comments,]);
    // }


    public function update(Request $request, Comment $comment){
        $this->authorize('update', $comment); // Assurez-vous que c'est le propriétaire
        $request->validate(['content' => 'required|string']);
        $comment->update(['content' => $request->content]);
        return response()->json(['content' => $comment->content]);
    }

    public function destroy(Comment $comment){
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['success' => true]);
    }
}
