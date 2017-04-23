<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;
use Session;
use Profanity;
use App\Subscriber;
use Mail;

class Filter_String  {
var $strings;
var $text;
var $keep_first_last;
var $replace_matches_inside_words;
function filter()
{
$new_text = '';
$regex = '/<\/?(?:\w+(?:=["\'][^\'"]*["\'])?\s*)*>/'; // Tag Extractor
preg_match_all($regex, $this->text, $out, PREG_OFFSET_CAPTURE);
$array = $out[0];
if(!empty($array))
{
if($array[0][1] > 0)
{
$new_text .= $this->do_filter(substr($this->text, 0, $array[0][1]));
}
foreach($array as $value)
{
$tag = $value[0];
$offset = $value[1];
$strlen = strlen($tag); // characters length of the tag
$start_str_pos = ($offset + $strlen); // start position for the non-tag element
$next = next($array);
// end position for the non-tag element
$end_str_pos = $next[1];
// no end position? 
// This is the last text from the string and it is not followed by any tags
if(!$end_str_pos) $end_str_pos = strlen($this->text);
// Start constructing the new resulted string. We'll add tags now!
$new_text .= substr($this->text, $offset, $strlen);
$diff = ($end_str_pos - $start_str_pos);
// Is this a simple string without any tags? Apply the filter to it
if($diff > 0)
{ 
$str = substr($this->text, $start_str_pos, $diff);
$str = $this->do_filter($str);
$new_text .= $str; // Continue constructing the text with the (filtered) text
}
}
}
else // No tags were found in the string? Just apply the filter
{
$new_text = $this->do_filter($this->text);
}
return $new_text;
}
function do_filter($var)
{
if(is_string($this->strings)) $this->strings = array($this->strings);
foreach($this->strings as $word)
{
$word = trim($word);
$replacement = '';
$str = strlen($word);
$first = ($this->keep_first_last) ? $word[0] : '';
$str = ($this->keep_first_last) ? $str - 2 : $str;
$last = ($this->keep_first_last) ? $word[strlen($word) - 1] : '';
$replacement = str_repeat('*', $str);
if($this->replace_matches_inside_words)
{
$var = str_replace($word, $first.$replacement.$last, $var);
}
else
{
$var = preg_replace('/\b'.$word.'\b/i', $first.$replacement.$last, $var);
}
}
return $var;
}
}

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //create a variable and save all blog p[ost in that
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        ////return a view and pass in the above variable
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
            'title'         => 'required|max:255',
            'slug'          => 'required|alpha-dash|min:5|max:255|unique:posts,slug',
            'category_id'   => 'required|integer',
            'body'          => 'required',
            'image_path'    => 'image'
        ));

        //store in the database
        $post = new Post;
        $post->title       = $request->title;
        $post->slug        = $request->slug;
        $post->category_id = $request->category_id;
        $filter = new Filter_String;
        $filter->text = $request->body;
        $filter->strings = array('shit','fuck','ass', 'idiot', 'stupid','bitch','dumb','fucking','fucker','fucktard','fucked','fuckface','dipshit','shitface','chutiya','bhenchod','madarchod','kutta','kamina','harami','haram');
        $filter->replace_matches_inside_words = false;
        $post->body        = $filter->filter();
        if( $request->hasFile('image') ) {
            $file = $request->file('image');
            $imageName = $request->slug . '.' . $file->getClientOriginalExtension();
            $file->move(base_path() . '/public/images/post/', $imageName);
            $post->image_path  = "/images/post/" . $imageName;
        }
        $post->save();

        $subscribers = Subscriber::all();

        Mail::send('emails.subscribe',
            array(
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'category_id' => $post->category_id,
                    'body' => $post->body,
                    'created_at' => $post->created_at,
                    'category' => $post->category->name,
                    'image_path' => url('/') . "{$post->image_path}"

                ), 
                function($message) use($subscribers, $post)
                {   
                    foreach ($subscribers as $subscriber) {
                        $message->from('noreply@tnineblog.com');
                        $message->to($subscriber->email);
                        $message->subject("New Post : {$post->title}");
                    }

                });

        Session::flash('success', 'The Blog post has been successfully created!');

        //redirect to another page
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the post in the database and save as a var
        $post       = Post::findOrFail($id);
        $categories = Category::all();
        $cats       = [];
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }

        //reurn the view and pass in the var created previously
        return view('posts.edit')->with('post', $post)->with('categories', $cats);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        //Validate the data
        if ($request->input('slug') == $post->slug) {
            $this->validate($request, array(
                'title'       => 'required|max:255',
                'category_id' => 'required|integer',
                'body'        => 'required',
                'image_path'  => 'image|dimensions:min_width=400,min_height=600'
            ));
        } else {
            $this->validate($request, array(
                'title'       => 'required|max:255',
                'slug'        => 'required|alpha-dash|min:5|max:255|unique:posts,slug',
                'category_id' => 'required|integer',
                'body'        => 'required',
            ));
        }

        //Save the data to the database
        $post->title       = $request->input('title');
        $post->slug        = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body        = $request->input('body');

        $post->save();

        //set flash data with the success message
        Session::flash('success', 'The post has been successfully updated!');

        //redirect with flash message to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
