<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CommentRequest;
use App\Http\Resources\API\CommentResource;
use App\Models\Article;
use App\Models\Comment;

class Comments extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    public function store(CommentRequest $request, Article $article)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->fill($data)->article()->associate($article)->save();
        return new CommentResource($comment);
    }

    public function show(Article $article, Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(CommentRequest $request, Article $article, Comment $comment)
    {
        $data = $request->all();
        $comment->fill($data)->article()->associate($article)->save();
        return new CommentResource($comment);
    }

    public function destroy(Article $article, Comment $comment)
    {
        $comment->delete();
        return response(null, 204);
    }
}
