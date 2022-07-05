<?php

namespace App\Http\Controllers;

use App\Models\Newsfeed;
use Illuminate\Http\Request;

class NewsfeedController extends Controller
{
    public function index(){
        $newsfeeds = Newsfeed::orderBy('id', 'desc')->get();
        return view('pages.newsfeeds.index', compact('newsfeeds'));
    }

    public function store(Request $request){
        try{
            $this->validate($request,[
                'subject' => 'required',
                'body' => 'required',
                'group_id' => 'required'
            ]);
            $group_id = $request->group_id;
            $subject = $request->subject;
            $body = $request->body;
            $news = new Newsfeed();
            $news->id = newId();
            $news->user_id = auth()->id();
            $news->group_id = $group_id;
            $news->subject = $subject;
            $news->body = $body;
            $news->save();
            return back()->with('message', 'News sent successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
