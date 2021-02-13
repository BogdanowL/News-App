<?php

namespace App\Http\Controllers;

use App\News;
use App\Tag;
use Auth;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
       // dd($request->all());
        $note = News::add($request->all());
        $note->setTags($request->get('tags'));
        $note->save();
        return redirect()->back();
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $note = News::find($id);
        if (Auth::user()->id != $note->user_id)
        {
            return redirect()->back();
        }
        $tags = Tag::pluck('title', 'id')->all();
        return view('edit', compact('note', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $note = News::find($id);
        $note->edit($request->all());
        $note->setTags($request->get('tags'));
        return redirect()->route('home');
    }


    public function destroy($id)
    {
        News::find($id)->delete();
        return redirect()->back();
    }
}
