<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = ["content", "title"];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function relativeDate()
    {
        return $this->created_at->diffForHumans();
    }

    public function truncate()
    {
        // use the Laravel Str::limit method
        return Str::limit($this->content, 20);
    }

    public function setTags(array $strings) : Article
    {
        $tags = Tag::fromStrings($strings);

        // we're on an article instance, so use $this
        // pass in collection of IDs
        $this->tags()->sync($tags->pluck("id"));

        // return $this in case we want to chain
        return $this;
    }
}
