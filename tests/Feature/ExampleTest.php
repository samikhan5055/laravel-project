<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_redirects_to_students(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/students');
    }

    public function test_students_page_loads_successfully(): void
    {
        $response = $this->get('/students');

        $response->assertOk();
    }
}
