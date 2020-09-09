<?php

namespace Tests\Unit\Http\Controllers\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\Http\Requests\API\ArticleRequest;
use App\Http\Controllers\API\Articles;
use App\Models\Article;

class ArticlesTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        // create some articles
        Article::create(["title" => "Blah #1", "content" => "Blah blah blah"]);
        Article::create(["title" => "Blah #2", "content" => "Blah blah blah"]);

        // fake a GET request
        $response = $this->call('GET', '/api/articles')->getOriginalContent();

        // check we get back two articles
        $this->assertSame(2, $response->count());

        // check we get back the first article first
        $this->assertSame("Blah #1", $response->get(0)->title);
    }

    public function testStore()
    {
        // fake a POST request with data
        $response = $this->call('POST', '/api/articles', [
            "title" => "foo",
            "content" => "bar",
            "tags" => ["fish", "blah"],
        ])->getOriginalContent();

        // check we get back an article
        $this->assertSame("bar", $response->content);
        $this->assertSame(2, $response->tags->count());

        // check it's been added to the database
        $article = Article::all()->first();
        $this->assertSame("bar", $article->content);
    }

    public function testShow()
    {
        // create an article
        Article::create(["title" => "Blah #1", "content" => "Blah blah blah"]);

        // fake a GET request for the article with id 1
        $response = $this->call('GET', '/api/articles/1')->getOriginalContent();

        // check it's the article we created
        $this->assertSame("Blah #1", $response->title);
    }

    public function testUpdate()
    {
        // create an article
        Article::create(["title" => "Blah #1", "content" => "Blah blah blah"]);

        // fake a PUT request for that article
        $response = $this->call('PUT', '/api/articles/1', [
            "title" => "foo",
            "content" => "Blah blah blah",
            "tags" => ["fish", "blah"],
        ])->getOriginalContent();

        // check the title has changed
        $this->assertSame("foo", $response->title);
        $this->assertSame(2, $response->tags->count());

        // check we've not *added* a new article
        $articles = Article::all();
        $this->assertSame(1, $articles->count());
        $this->assertSame("foo", $articles->first()->title);
        $this->assertSame(2, $articles->first()->tags->count());
    }

    public function testDestroy()
    {
        // create an article
        Article::create(["title" => "Blah #1", "content" => "Blah blah blah"]);

        // fake a DELETE request for that article
        $response = $this->call('DELETE', '/api/articles/1');

        // check it's been removed from the database
        $this->assertTrue(Article::all()->isEmpty());
    }
}
