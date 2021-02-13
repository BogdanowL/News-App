<?php

namespace App\Http\Controllers;

use App\News;
use App\Tag;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{

    public function index()
    {
      $news = News::latest()->paginate(5);
      $tags = Tag::pluck('title', 'id')->all();
      $tag = Tag::latest()->paginate(2);
      $users = User::latest()->paginate(2);
      return view('home', compact('news', 'tags', 'users', 'tag'));
    }

    public function getUser()
    {
        return json_encode(Auth::user());
    }


}
