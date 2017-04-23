<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Comment;
use Session;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $this->validate($request, array(
            'name' => 'required|max:255',
            'content' => 'required'
            ));
        $comment = new Comment();
        $post = Post::where('id', '=', $id)->first();
        $comment->name = $request->name;
        $comment->content = $request->content;
        $comment->post_id = $post->id;

        $comment->save();
        $post->increment('post_comment_count');

        return redirect()->route('blog.single', $post->slug);
    }

    public function delete(Request $request, $id)
    {
        $comment = Comment::where('id', '=', $id)->first();
        $slug = $comment->post_id;
        $comment->delete();

        //reurn the view and pass in the var created previously
        return redirect()->route('blog.single', Post::where('id', '=', $slug)->first()->slug);
    }

    public function edit(Request $request, $id)
    {
       
        $comment = Comment::where('id', '=', $id)->first();
        $slug = $comment->post_id;

       return redirect()->route('comments.update', Post::where('id', '=', $slug)->first()->slug, Comment::where('id', '=', $id)->first());
    }

    public function update(Request $request, $name)
    {
        $comment = Comment::where('name','=',$name)->first();
        
        //Validate the data
        if ($request->input('name') == $comment->name) {
            $this->validate($request, array(
                'name' => 'required|max:255',
                'content' => 'required'
            ));
        } else {
            $this->validate($request, array(
                'name' => 'required|max:255',
                'content' => 'required',
            ));
        }

        //Save the data to the database
        $comment->name           = $request->input('name');
        $comment->content        = $request->input('content');
        

        $comment->save();
        // $post->save();

        //set flash data with the success message
        Session::flash('success', 'The post has been successfully updated!');

        //redirect with flash message to posts.show
        return redirect()->route('posts.show', $comment->id);
    }

}
