<?php

namespace Tests\Feature;

use App\User;
use Kregel\LaravelAbstract\LaravelAbstract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomQueryBuilderFilters extends TestCase
{
    use RefreshDatabase;

    public function testSearchTestWithoutBypassSuccess()
    {
        LaravelAbstract::bind()->bypass(false);
        factory(User::class, 5)->create();
        factory(User::class)->create([
            'name' => 'Bobby Tarantino - Logic',
            'email' => 'john@example.com'
        ]);
        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);
        factory(User::class, 5)->create();

        $response = $this->actingAs($user)
            ->get('/api/users?filter[q]=Bobby+Tarantino+-+Logic');

        $response->assertStatus(200);

        $response->assertJson([
            'total' => 1,
            'current_page' => 1,
            'per_page' => 14,
            'from' => 1,
            'to' => 1,
            'last_page' => 1
        ])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'email',
                        'name',
                    ]
                ]
            ])
            ->assertJsonFragment([
                'name' => 'Bobby Tarantino - Logic',
                'email' => 'john@example.com'
            ]);
    }
}
