<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use App\Models\Tag;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    public function testFromString()
    {
        // test we get a Tag back
        $result = Tag::fromString("Test");
        $this->assertInstanceOf(Tag::class, $result);
        $this->assertSame("Test", $result->name);

        // test a different tag
        $result = Tag::fromString("Hammock");
        $this->assertInstanceOf(Tag::class, $result);
        $this->assertSame("Hammock", $result->name);

        // test added to the database
        $tagFromDB = Tag::all()->first();
        $this->assertInstanceOf(Tag::class, $tagFromDB);
        $this->assertSame("Test", $tagFromDB->name);

        // test no duplicates
        $result = Tag::fromString("Test");
        $allTags = Tag::where("name", "Test");
        $this->assertSame(1, $allTags->count());

        // test whitespace is removed
        $result = Tag::fromString("   Hammock ");
        $this->assertSame("Hammock", $result->name);

        // check only "Test" and "Hammock" are in the database
        $tagsFromDB = Tag::all();
        $this->assertSame(2, $tagsFromDB->count());
    }

    public function testFromStrings()
    {
        // call the fromStrings method
        $result = Tag::fromStrings(["Test", "Hammock"]);

        // check it's a Collection
        $this->assertInstanceOf(Collection::class, $result);

        // check the first item is "Test"
        $this->assertSame("Test", $result->get(0)->name);

        // check the second item is "Hammock"
        $this->assertSame("Hammock", $result->get(1)->name);

        // call the fromStrings method
        $result = Tag::fromStrings(["Penguin", "Wombat", "Penguin"]);
        $this->assertSame(2, $result->count());
    }
}
