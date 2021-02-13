<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $fillable = ['title', 'description', 'text'];


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'news_tags',
            'news_id',
            'tag_id'

        );
    }

    public function setTags($ids)
    {

        if ($ids == null) { return; }

        $this->tags()->sync($ids);
    }

    public static function add($fields)
    {
        $note = new static;
        $note->fill($fields);
        $note->user_id = Auth::user()->id;
        $note->save();
        return $note;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }


}
