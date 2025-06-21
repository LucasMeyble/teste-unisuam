<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class GitHubControllerTest extends TestCase
{
    public function test_get_user_returns_formatted_data()
    {
        Http::fake([
            'api.github.com/users/testuser' => Http::response([
                'login' => 'testuser',
                'avatar_url' => 'url',
                'name' => 'Nome Teste',
                'bio' => 'bio',
                'html_url' => 'link',
                'blog' => 'blog',
                'company' => 'empresa',
                'location' => 'local',
                'public_repos' => 10,
                'followers' => 5,
                'following' => 8
            ], 200)
        ]);

        $response = $this->getJson('/api/github/user/testuser');

        $response->assertOk()->assertJsonFragment(['username' => 'testuser']);
    }

    public function test_get_followings_returns_list()
    {
        Http::fake([
            'api.github.com/users/testuser/following*' => Http::response([
                ['login' => 'f1'],
                ['login' => 'f2']
            ], 200)
        ]);

        $response = $this->getJson('/api/github/user/testuser/followings?page=1&per_page=2');

        $response->assertOk()->assertJsonFragment(['login' => 'f1']);
    }

    public function test_get_user_not_found()
    {
        Http::fake([
            'api.github.com/users/naoexiste' => Http::response(['message' => 'Not Found'], 404)
        ]);

        $response = $this->getJson('/api/github/user/naoexiste');

        $response->assertStatus(404)->assertJson(['error' => 'Usuário não encontrado ou erro na API do GitHub']);
    }
}
