<?php

namespace Tests\Feature;

use App\User;
use Kregel\LaravelAbstract\LaravelAbstract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ByPassApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $response = $this->actingAs(factory(User::class)->create())->get('/api/users');

        $response->assertStatus(200);
    }

    public function testCreateTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $response = $this->actingAs(factory(User::class)->create())
            ->post('/api/users', [
                'name' => 'Austin',
                'password' => bcrypt('000000'),
                'email' => 'austin@kbco.me',
            ]);

        $response->assertStatus(201);
    }

    public function testUpdateTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->put('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(['name' => 'Austin Kregel']);
    }

    public function testUpdatePatchTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->patch('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(['name' => 'Austin Kregel']);
    }

    public function testDeleteTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', $user2->toArray());
    }

    public function testForceDeleteTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id.'/force');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', $user2->toArray());
    }

    public function testShowTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/api/users/'.$user->id);

        $response->assertStatus(200);

        $response->assertJson($user->toArray());
    }

    public function testSoftDeleteTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', $user2->toArray());
    }

    public function testRestoreTestWithBypass()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/api/force_users/'.$user->id.'/restore');

        $response->assertStatus(200);

        $response->assertJson($user->toArray());
    }

    public function testRestoreTestWithBypassFailsIfTheModelDoesHaveSoftdeletes()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/api/users/'.$user->id.'/restore');

        $response->assertStatus(404);
    }

    public function testForceDeleteTestWithBypassFailsIfTheModelDoesHaveSoftdeletes()
    {
        LaravelAbstract::bind()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id.'/force');

        $response->assertStatus(404);

        $this->assertDatabaseHas('users', $user2->toArray());
    }
}
