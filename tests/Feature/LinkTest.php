<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_submit_link()
    {
        $link = $this->create_link();

        $this->assertCount(1, Link::all());

        //still draft not show in index page
        $this->assertDatabaseHas('links', [ 'draft' => 1 ]);
        $this->get('/')->assertDontSee($link->title);
    }

    /** @test */
    public function unverified_user_cannot_submit_link()
    {
        $newUser = [
            'username'              => 'mynewusername',
            'email'                 => 'username@example.net',
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->post('/register', $newUser);
 
        $res = $this->actingAs(User::first())
             ->from('/')
             ->get('/link/create')
             ->assertRedirect('/email/verify');
    }

    private function create_link() 
    {
        $this->signIn();
        $this->get('/link/create')->assertStatus(200);
        $link = Link::factory()->make();   
        $this->post('/link', $link->toArray());

        return $link;
    }

    /** @test */
    public function published_link_shown_in_index()
    {
        $this->signIn();
        $link = Link::factory()->create(['draft' => 0]);   
        
        $this->assertDatabaseHas('links', [ 'draft' => 0 ]);
        $this->get('/')->assertSee($link->title);
    }

    /** @test */
    public function guest_can_open_single_link()
    {
        Link::factory()->count(3)->create();
        $this->get('/link/' . Link::first()->slug)->assertStatus(200);
    }

    /** @test */
    public function owner_can_edit_link()
    {
        $link = Link::factory()->create();   
        $owner = User::find($link->user_id);

        $this->actingAs($owner)
                ->get('/link/'. $link->slug .'/edit')->assertStatus(200);
    }

    /** @test */
    public function not_owner_cannot_edit_link()
    {
        $link = Link::factory()->create();  
        $user = User::factory()->create();
        
        $this->actingAs($user)
              ->get('/link/'. $link->slug .'/edit')->assertStatus(403);
    }


    /** @test */
    public function owner_can_update_link()
    {
        $link = Link::factory()->create();   
        $owner = User::find($link->user_id);

        $newAttr = [
            'title' => 'new title test here', 
            'body' => 'new title body here it aint ther test test',
            'url' => 'https://google.com',
            'tags' => 'javascript',
            'media' => 'tulisan',
            'owner' => 'some owner'
        ];

        $this->actingAs($owner)
             ->put('/link/'. $link->slug, $newAttr);
       
        $this->assertDatabaseHas('links', [
                'title' => $newAttr['title'],
                'body' => $newAttr['body'],
        ]);
    }

    /** @test */
    public function owner_can_delete_link()
    {
        $link = Link::factory()->create();   
        $owner = User::find($link->user_id);
        
        $this->actingAs($owner)
             ->delete('/link/'. $link->slug);
       
       $this->assertCount(0, Link::all());
    }

    /** @test */
    public function not_owner_cannot_delete_link()
    {
        $link = Link::factory()->create();   
        $user = User::factory()->create();
        
        $this->actingAs($user)
             ->delete('/link/'. $link->slug);
       
       $this->assertCount(1, Link::all());
    }

    /** @test */
    public function user_can_scrape_url()
    {
        $this->signIn();
        $this->post('/scrape', ['url' => 'https://google.com'])
            ->assertJson([
                'title' => 'Google',
            ]);
    }

}
