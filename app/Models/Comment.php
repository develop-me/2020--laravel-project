<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ["email", "comment"];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
