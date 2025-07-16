<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_user_with_multiple_addresses()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-14',
            'gender' => 'Male',
            'mobile' => '9345345352',
            'addresses' => [
                [
                    'address_type' => 'home',
                    'door_street' => '1st Main Rd, Rajiv Nagar',
                    'landmark' => 'Zxy building',
                    'city' => 'Chennai',
                    'state' => 'Tamilnadu',
                    'country' => 'India',
                    'primary' => 'No',
                ],
                [
                    'address_type' => 'office',
                    'door_street' => 'West Cross Rd, Chinmayi Nagar',
                    'landmark' => 'White Cross building',
                    'city' => 'Brooklyn',
                    'state' => 'Newyork',
                    'country' => 'USA',
                    'primary' => 'No',
                ]
            ],
        ];

        $response = $this->post('/users', $data);

        $response->assertStatus(302); // redirect expected
        $this->assertDatabaseHas('users', ['first_name' => 'John']);
        $this->assertDatabaseCount('addresses', 2);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = User::factory()->create();

        $response = $this->put("/users/{$user->id}", [
            'first_name' => 'UpdatedName',
            'last_name' => 'UpdatedLast',
            'dob' => '1992-02-02',
            'gender' => 'Male',
            'mobile' => '1111111111',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['first_name' => 'UpdatedName']);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->delete("/users/{$user->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_searches_users_by_name()
    {
        User::factory()->create(['first_name' => 'Alice']);
        User::factory()->create(['first_name' => 'Bob']);

        $response = $this->get('/users?search=Alice');

        $response->assertStatus(200);
        $response->assertSee('Alice');
        $response->assertDontSee('Bob');
    }

    /** @test */
    public function it_shows_paginated_users()
    {
        User::factory()->count(25)->create();

        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertSee('class="pagination"', false);
    }

    /** @test */
    public function it_returns_formatted_api_response_for_user()
    {
        $user = User::factory()->create([
            'first_name' => 'home_page',
            'mobile' => '9345345352',
            'dob' => '1990-01-14',
            'gender' => 'Male',
        ]);

        $user->addresses()->createMany([
            [
                'address_type' => 'home',
                'door_street' => '1st Main Rd, Rajiv Nagar',
                'landmark' => 'Zxy building',
                'city' => 'chennai',
                'state' => 'tamilnadu',
                'country' => 'India',
                'primary' => 'No',
            ],
            [
                'address_type' => 'office',
                'door_street' => 'west cross Rd, chinmayi Nagar',
                'landmark' => 'white cross building',
                'city' => 'Brooklyn',
                'state' => 'Newyork',
                'country' => 'USA',
                'primary' => 'No',
            ],
        ]);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'user_name' => 'home_page',
                'mobile' => '9345345352',
                'dob' => '14/01/1990',
                'gender' => 'Male',
            ])
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'user_name',
                    'mobile',
                    'dob',
                    'gender',
                    'Address' => [
                        [
                            'address_type',
                            'address1',
                            'primary'
                        ],
                        [
                            'address_type',
                            'address2',
                            'primary'
                        ]
                    ]
                ]
            ]);
    }
}
