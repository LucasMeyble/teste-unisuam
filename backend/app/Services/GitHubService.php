<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ApiLog;

class GitHubService
{
    public function fetchUser($username)
    {
        $endpoint = "https://api.github.com/users/{$username}";
        return $this->requestGitHub('GET', $endpoint);
    }

    public function fetchFollowings($username, $page = 1, $perPage = 30)
    {
        $endpoint = "https://api.github.com/users/{$username}/following?page={$page}&per_page={$perPage}";
        return $this->requestGitHub('GET', $endpoint);
    }

    private function requestGitHub($method, $endpoint)
    {
        $response = Http::withHeaders(['Accept' => 'application/vnd.github.v3+json'])->$method($endpoint);

        // Log da requisição
        ApiLog::create([
            'method' => $method,
            'endpoint' => $endpoint,
            'payload' => null,
            'status_code' => $response->status(),
            'response' => $response->json(),
        ]);

        return $response;
    }
}
