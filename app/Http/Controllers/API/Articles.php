<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ArticleRequest;
use App\Http\Resources\API\ArticleResource;
use App\Http\Resources\API\ArticleListResource;
use App\Models\Article;

class Articles extends Controller
{
    public function index()
    {
        return ArticleListResource::collection(Article::all());
    }

    public function store(ArticleRequest $request)
    {
        $data = $request->all();
        $article = Article::create($data)->setTags($request->get("tags"));
        return new ArticleResource($article);
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->all();
        $article->fill($data)->save();
        $article->setTags($request->get("tags"));
        return new ArticleResource($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response(null, 204);
    }
}
