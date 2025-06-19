<?php

namespace App\Http\Controllers;

use App\Services\GitHubService;
use Illuminate\Http\Request;
use App\Http\Resources\GitHubUserResource;

class GitHubController extends Controller
{
    protected $github;

    public function __construct(GitHubService $github)
    {
        $this->github = $github;
    }

    public function getUser($username)
    {
        $response = $this->github->fetchUser($username);

        if ($response->failed()) {
            return response()->json(['error' => 'Usuário não encontrado ou erro na API do GitHub'], $response->status());
        }

        return new GitHubUserResource($response->json());
    }

    public function getFollowings(Request $request, $username)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 30);

        $response = $this->github->fetchFollowings($username, $page, $perPage);

        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao buscar followings'], $response->status());
        }

        return $response->json();
    }
}
