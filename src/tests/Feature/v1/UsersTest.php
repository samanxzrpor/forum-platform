<?php

namespace Tests\Feature\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllUsersInLeaderboard()
    {
        $users = User::factory(20)->create();
        $response = $this->get(route('users.leaderboard'));


        $response->assertStatus(200);
        $this->assertCount(20, $response->json()['data']);
    }

}
