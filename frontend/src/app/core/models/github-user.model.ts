export interface GithubUser {
  avatar_url: string;
  name: string;
  username: string;
  bio: string;
  github_url: string;
  blog_url: string;
  company: string;
  location: string;
  public_repos: number;
  followers: number;
  following: number;
}

export interface GithubFollowing {
  login: string;
  avatar_url: string;
  html_url: string;
}
