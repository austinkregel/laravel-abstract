<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Arr;
use Kregel\LaravelAbstract\LaravelAbstract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ByPassApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTestWithBypass()
    {
        abstracted()->bypass(true);

        $response = $this->actingAs(factory(User::class)->create())->get('/api/users');

        $response->assertStatus(200);
    }

    public function testCreateTestWithBypass()
    {
        abstracted()->bypass(true);

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
        abstracted()->bypass(true);

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
        abstracted()->bypass(true);

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
        abstracted()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', Arr::except($user2->toArray(), ['email_verified_at']));
    }

    public function testForceDeleteTestWithBypass()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id.'/force');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', Arr::except($user2->toArray(), ['email_verified_at']));
    }

    public function testShowTestWithBypass()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/api/users/'.$user->id);

        $response->assertStatus(200);

        $response->assertJson($user->toArray());
    }

    public function testSoftDeleteTestWithBypass()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', Arr::except($user2->toArray(), ['email_verified_at']));

    }

    public function testRestoreTestWithBypass()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/api/force_users/'.$user->id.'/restore');

        $response->assertStatus(200);

        $response->assertJson(Arr::except($user->toArray(), ['email_verified_at']));
    }

    public function testRestoreTestWithBypassFailsIfTheModelDoesHaveSoftdeletes()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/api/users/'.$user->id.'/restore');

        $response->assertStatus(404);
    }

    public function testForceDeleteTestWithBypassFailsIfTheModelDoesHaveSoftdeletes()
    {
        abstracted()->bypass(true);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id.'/force');

        $response->assertStatus(404);

        $this->assertDatabaseHas('users', Arr::except($user->toArray(), ['email_verified_at']));
    }
}
