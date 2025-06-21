import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { GithubUser, GithubFollowing } from '../models/github-user.model';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class GithubService {
  private baseUrl = 'http://localhost:8000/api/github/user';

  constructor(private http: HttpClient) {}

  getUser(username: string): Observable<{ data: GithubUser }> {
    return this.http.get<{ data: GithubUser }>(`${this.baseUrl}/${username}`);
  }

  getFollowings(username: string, page = 1, perPage = 10): Observable<GithubFollowing[]> {
    return this.http.get<GithubFollowing[]>(
      `${this.baseUrl}/${username}/followings?page=${page}&per_page=${perPage}`
    );
  }
}
