<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/v1/register', [
            'name' => 'John Test',
            'email' => 'john@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response
            ->assertStatus(201)
            ->assertSee('john@test.com')
            ->assertSee('John Test');
    }

    public function test__wrong_password_confirmation()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/v1/register', [
            'name' => 'John Test',
            'email' => 'john@test.com',
            'password' => 'password',
            'password_confirmation' => 'pass'
        ]);

        $response
            ->assertStatus(422)
            ->assertSee('The password confirmation does not match.')
            ->assertSee('The given data was invalid.');
    }
}
