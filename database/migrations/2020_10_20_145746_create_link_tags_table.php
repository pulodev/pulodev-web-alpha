<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->bigInteger('link_id')->unsigned()->nullable();
            $table->bigInteger('tag_id')->unsigned()->nullable();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->index(['link_id', 'tag_id']);
        });

        
        $links = DB::select('select * from `links`');
        $tagLinks = [];
        foreach ($links as $link) {
            $tags = explode(',',$link->tags);
            foreach($tags as $tag){
                $tag = trim($tag);
                if(!empty($tag)){
                    DB::table('tags')->insertOrIgnore(['name'=>$tag]);
                    $tagItem = DB::table('tags')->select('id','name')->where('name',$tag)->first();
                    $tagLinks[] = [
                        'link_id'=> $link->id,
                        'tag_id'=> $tagItem->id
                    ];
                }
            }
            
        }

        DB::table('link_tags')->insert($tagLinks);

        // Schema::table('links', function (Blueprint $table) {
        //     $table->dropColumn('tags');
        // });

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
