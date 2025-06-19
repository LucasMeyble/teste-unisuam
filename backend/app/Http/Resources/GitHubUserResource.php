<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GitHubUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'avatar_url'   => $this['avatar_url'],
            'name'         => $this['name'],
            'username'     => $this['login'],
            'bio'          => $this['bio'],
            'github_url'   => $this['html_url'],
            'blog_url'     => $this['blog'],
            'company'      => $this['company'],
            'location'     => $this['location'],
            'public_repos' => $this['public_repos'],
            'followers'    => $this['followers'],
            'following'    => $this['following'],
        ];
    }
}
