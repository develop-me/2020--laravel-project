<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

    private $article;

    public function __construct()
    {
        parent::__construct();

        $this->article = new Article([
            "title" => "Hello",
            "content" => "Blah blah blah",
        ]);
    }

    public function testTitle()
    {
        $this->assertSame("Hello", $this->article->title);
    }

    public function testTruncate()
    {
        $this->assertSame("Blah blah blah", $this->article->truncate());

        $article = new Article([
            "title" => "Hello",
            "content" => "Blah blah blah blah blah blah blah"
        ]);

        $this->assertSame("Blah blah blah blah...", $article->truncate());
    }

    public function testDatabase()
    {
        Article::create([
            "title" => "Hello",
            "content" => "Blah blah blah",
        ]);

        $this->assertSame("Hello", Article::all()->first()->title);
    }

    public function testSetTags()
    {
        Article::create([
            "title" => "Hello",
            "content" => "Blah blah blah",
        ]);

        // get the article
        $article = Article::all()->first();

        // add some tags
        $article->setTags(["blah", "flah", "blah"]);

        // check the article from the DB has the tags
        $fromDB = Article::all()->first();
        $this->assertSame(2, $fromDB->tags->count());

        // check tags are removed
        $fromDB->setTags(["blah"]);
        $fromDB = Article::all()->first();
        $this->assertSame(1, $fromDB->tags->count());
    }
}
