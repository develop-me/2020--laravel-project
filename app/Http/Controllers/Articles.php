<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\CommentRequest;

class Articles extends Controller
{
    // shows all articles
    public function index()
    {
        return view("articles/list", [
            "articles" => Article::paginate(10)
        ]);
    }

    // shows search result
    public function search(Request $request)
    {
        $query = $request->get("query");

        $articles = Article::where("title", "like", "%{$query}%")
                           ->orWhere("content", "like", "%{$query}%")
                           ->get();

        return view("articles/search", [
            "query" => $query,
            "articles" => $articles,
        ]);
    }

    // shows single article
    public function show(Article $article)
    {
        return view("articles/show", [
            "article" => $article
        ]);
    }

    // shows create article form
    public function create()
    {
        return view("articles/form", [
            "title" => "Create Article",
            "button" => "Create",
            "article" => null,
        ]);
    }

    public function createPost(ArticleRequest $request)
    {
        $data = $request->all();
        Article::create($data);

        return redirect("/");
    }

    // show edit article form
    public function edit(Article $article)
    {
        return view("articles/form", [
            "title" => "Edit Article",
            "button" => "Save",
            "article" => $article,
        ]);
    }

    public function editPost(Article $article, ArticleRequest $request)
    {
        $data = $request->all();
        $article->fill($data)->save();

        return redirect("/articles/{$article->id}");
    }

    // comment form
    public function commentPost(Article $article, CommentRequest $request)
    {
        $data = $request->all();
        $comment = new Comment($data);
        $article->comments()->save($comment);

        return redirect("/articles/{$article->id}");
    }
}
