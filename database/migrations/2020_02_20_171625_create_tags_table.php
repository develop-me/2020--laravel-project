<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // create the tags table
      // it's a termlist so call the string column name
      // don't need timestamps - not very useful here
      Schema::create("tags", function (Blueprint $table) {
        $table->bigIncrements("id");
        $table->string("name", 30);
      });

      // create the pivot table using the Eloquent naming convention
      Schema::create("article_tag", function (Blueprint $table) {
        // still have an id column
        $table->bigIncrements("id");

        // create the article id column and foreign key
        $table->foreignId("article_id")
              ->constrained()
              ->onDelete("cascade");

        // create the tag id column and foreign key
        $table->foreignId("tag_id")
              ->constrained()
              ->onDelete("cascade");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // remove the pivot table first
        // otherwise all the tags foreign key contraints would fail
        Schema::dropIfExists("article_tag");

        // then drop the tags table
        Schema::dropIfExists("tags");
    }
}
