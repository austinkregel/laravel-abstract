<?php

namespace Tests\Feature;

use App\User;
use Kregel\LaravelAbstract\LaravelAbstract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DontBypassApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $response = $this->actingAs(factory(User::class)->create())->get('/api/users');

        $response->assertStatus(403);
    }

    public function testCreateTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $response = $this->actingAs(factory(User::class)->create())
            ->post('/api/users', [
                'name' => 'Austin',
                'password' => bcrypt('000000'),
                'email' => 'austin@kbco.me',
            ]);

        $response->assertStatus(403);
    }

    public function testUpdateTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->put('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(403);
    }

    public function testUpdatePatchTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->patch('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(403);
    }

    public function testDeleteTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id);

        $response->assertStatus(403);
    }

    public function testShowTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/api/users/'.$user->id);

        $response->assertStatus(403);
    }

    public function testSoftDeleteTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id);

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', $user2->toArray());
    }

    public function testRestoreTestWithoutBypassFails()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create([
            'deleted_at' => now()
        ]);

        $response = $this->actingAs($user)
            ->post('/api/force_users/'.$user2->id.'/restore');

        $response->assertStatus(403);
    }
}
