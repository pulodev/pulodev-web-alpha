<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function user_has_profile()
    {
        $user = $this->signIn();
        $this->get('/@' . $user->username)->assertSee('@'. $user->username);
    }

    /** @test */
    public function user_can_edit_profile()
    {
        $this->signIn();
        $this->get('/user/edit/')->assertStatus(200);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->signIn();
        
        $newAttr = [
            'username' => 'newusername',
            'fullname' => 'new fullname',
            'bio' => 'new bio here',
            'website' => 'https://newwebsite.com',
        ];

        $this->put('/user/update', $newAttr)
             ->assertRedirect('/@'. $newAttr['username']);
    }
}
