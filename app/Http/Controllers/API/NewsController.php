<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index()
    {
         return News::with(['author:id,name', 'tags:id,title'])->latest()->paginate(3);
    }


    public function store(Request $request)
    {

        $note = new News([
            'user_id' => $request->get('user'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'text' => $request->get('text')
        ]);
        $note->save();

    }


    public function show($value)
    {
       
         return  News::where('id', $value)->orWhere('title', $value)
                ->orWhere('description', $value)
                ->orWhere('text', $value)->first();
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
