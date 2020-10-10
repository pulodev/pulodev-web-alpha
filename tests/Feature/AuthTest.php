<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_register()
    {
        Event::fake();
        $response = $this->post('/register', [
            'username'              => 'mynewusername',
            'email'                 => 'username@example.net',
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertRedirect('/');
        
        $this->assertCount(1, User::all());
        $this->assertDatabaseHas('users', [ 'email_verified_at' => null ]);
        
        $user = User::first();


        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }


    /** @test */
    public function user_cannot_view_a_login_form_when_authenticated()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'different-password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

}
