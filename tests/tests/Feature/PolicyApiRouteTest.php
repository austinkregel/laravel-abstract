<?php

namespace Tests\Feature;

use App\ForceUser;
use App\Policies\UserPolicy;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Kregel\LaravelAbstract\LaravelAbstract;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $response = $this->actingAs(factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]))->get('/api/users');

        $response->assertStatus(200);
    }

    public function testCreateTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $response = $this->actingAs(factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]))
            ->post('/api/users', [
                'name' => 'Austin',
                'password' => bcrypt('000000'),
                'email' => 'austin@kbco.me',
            ]);

        $response->assertStatus(201);
    }

    public function testUpdateTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);

        $response = $this->actingAs($user)
            ->put('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(['name' => 'Austin Kregel']);
    }

    public function testUpdatePatchTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);

        $response = $this->actingAs($user)
            ->patch('/api/users/'.$user->id, [
                'name' => 'Austin Kregel',
            ]);

        $response->assertStatus(200);

        $response->assertJsonFragment(['name' => 'Austin Kregel']);
    }

    public function testDeleteTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', $user2->toArray());
    }

    public function testShowTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);

        $response = $this->actingAs($user)
            ->get('/api/users/'.$user->id);

        $response->assertStatus(200);

        $response->assertJson($user->toArray());
    }

    public function testSoftDeleteTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        Carbon::setTestNow($now = Carbon::create(2019, 1, 1, 1, 1, 1));

        $user = factory(ForceUser::class)->create([
            'email' => 'github@austinkregel.com'
        ]);
        $user2 = factory(ForceUser::class)->create();

        $response = $this->actingAs($user)
            ->delete('/api/force_users/'.$user2->id);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', [
            'id' => $user2->id,
            'deleted_at' => $now
        ]);
    }

    public function testRestoreTestWithoutBypassSuccess()
    {
        abstracted()->bypass(false);

        $user = factory(User::class)->create([
            'email' => 'github@austinkregel.com'
        ]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/api/force_users/'.$user2->id.'/restore');

        $response->assertStatus(200);

        $response->assertJson([
            'email' => $user2->email,
            'deleted_at' => null
        ]);
    }
}
