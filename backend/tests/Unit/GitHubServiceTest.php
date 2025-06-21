<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\GitHubService;
use App\Models\ApiLog;

class GitHubServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_user_success()
    {
        Http::fake([
            'api.github.com/users/testuser' => Http::response(['login' => 'testuser'], 200),
        ]);

        $service = new GitHubService();
        $response = $service->fetchUser('testuser');

        $this->assertTrue($response->ok());
        $this->assertEquals('testuser', $response->json()['login']);
        $this->assertDatabaseHas('api_logs', ['endpoint' => 'https://api.github.com/users/testuser']);
    }

    public function test_fetch_followings_success()
    {
        Http::fake([
            'api.github.com/users/testuser/following*' => Http::response([['login' => 'f1']], 200),
        ]);

        $service = new GitHubService();
        $response = $service->fetchFollowings('testuser', 1, 10);

        $this->assertTrue($response->ok());
        $this->assertIsArray($response->json());
    }
}
