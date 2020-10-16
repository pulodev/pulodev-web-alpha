<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function user_can_submit_resource()
    {
        $this->signIn();
        $this->get('/resource/create')->assertStatus(200);
        
        $resource = Resource::factory()->make();   
        $this->post('/resource', $resource->toArray());

        $this->assertCount(1, Resource::all());
        $this->assertDatabaseHas('resources', [ 'title' => $resource->title ]);
    }
}
