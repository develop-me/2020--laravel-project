<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CommentRequest;
use App\Http\Resources\API\CommentResource;
use App\Models\Article;
use App\Models\Comment;

class Comments extends Controller
{
    public function index(Article $article)
    {
        // return all comments for a specific article
        return CommentResource::collection($article->comments);
    }

    public function store(CommentRequest $request, Article $article)
    {
        $data = $request->all();

        // create a new comment with the data
        $comment = new Comment($data);

        // associate the comment with an article
        $comment->article()->associate($article);

        // save the comment in the DB
        $comment->save();

        // return the new $comment
        return new CommentResource($comment);
    }

    public function show(Article $article, Comment $comment)
    {
        // return the comment
        // don't actually use $article, but required for route model binding
        return new CommentResource($comment);
    }

    public function update(CommentRequest $request, Article $article, Comment $comment)
    {
        $data = $request->all();

        // update the model with new data
        $comment->fill($data);

        // don't need to associate with article as shouldn't have changed
        // but $article required for route model binding
        // save the comment
        $comment->save();
        return new CommentResource($comment);
    }

    public function destroy(Article $article, Comment $comment)
    {
        $comment->delete();
        return response(null, 204);
    }
}
