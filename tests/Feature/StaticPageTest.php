<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaticPageTest extends TestCase
{
    /** @test */
    public function welcome_page_exists()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function static_pages()
    {
        $pages = [
            'login', 'register', 
            '/info/faq', '/info/about'
        ];

        for ($i=0; $i<count($pages) ; $i++) { 
           $this->get($pages[$i])->assertStatus(200);
        }
    }
}
