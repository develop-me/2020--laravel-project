<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends Model
{
    protected $fillable = ["name"];

    static public function fromStrings(array $strings) : Collection
    {
        return collect($strings)->map([Tag::class, "fromString"])->unique("name");
    }

    static public function fromString(string $string) : Tag
    {
        $string = trim($string);
        $tag = Tag::where("name", $string)->first();
        return $tag ? $tag : Tag::create(["name" => $string]);
    }

    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
