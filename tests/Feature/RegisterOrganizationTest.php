<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterOrganizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Organization registration test.
     *
     * @return void
     */
    public function test_organization_can_register()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/v1/register', [
            'name' => 'John Test',
            'email' => 'john@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'organization_name' => 'Manasoft',
            'organization_email' => 'info@manasoft.com',
            'organization_address' => '19 Kings Street, Avery, France',
            'organization_brief_info' => 'No info yet.'
        ]);

        $response
            ->assertStatus(201)
            ->assertSee('john@test.com')
            ->assertSee('John Test');
    }
}
