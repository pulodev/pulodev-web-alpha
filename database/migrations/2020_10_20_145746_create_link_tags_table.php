<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Link;

class CreateLinkTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_tags', function (Blueprint $table) {
            $table->foreign('link_id')->references('id')->on('link')->onDelete('delete');
            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('delete');
        });
        $links = Link::findAll();
        foreach($links as $link){
            $link->tag
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_tags');
    }
}
