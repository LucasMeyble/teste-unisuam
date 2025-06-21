import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { GithubService } from '../../core/services/github.service';
import { GithubUser, GithubFollowing } from '../../core/models/github-user.model';
import { NgIf, NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UserCardComponent } from '../../shared/user-card/user-card.component';

@Component({
  standalone: true,
  selector: 'app-user-detail',
  imports: [NgIf, NgFor, FormsModule, RouterModule, UserCardComponent],
  templateUrl: './user-detail.component.html',
  styleUrls: ['./user-detail.component.css']
})
export class UserDetailComponent implements OnInit {
  user?: GithubUser;
  followings: GithubFollowing[] = [];
  username = '';
  page = 1;
  perPage = 5;
  loading = false;
  searchTerm = '';
  hasMoreData = true;

  constructor(private route: ActivatedRoute, private githubService: GithubService) {}

  ngOnInit(): void {
    this.username = this.route.snapshot.paramMap.get('username')!;
    this.fetchUser();
    this.fetchFollowings();
  }

  fetchUser() {
    this.githubService.getUser(this.username).subscribe(res => {
      this.user = res.data;
    });
  }

  fetchFollowings() {
    this.loading = true;
    this.githubService.getFollowings(this.username, this.page, this.perPage).subscribe(res => {
      this.followings = res;
      this.loading = false;

      this.hasMoreData = res.length === this.perPage;
    });
  }

  nextPage() {
    this.page++;
    this.fetchFollowings();
  }

  prevPage() {
    if (this.page > 1) {
      this.page--;
      this.fetchFollowings();
    }
  }

  onPerPageChange() {
    this.page = 1; // volta pra primeira página
    this.fetchFollowings();
  }

  get filteredFollowings(): GithubFollowing[] {
    return this.followings.filter(user =>
      user.login.toLowerCase().includes(this.searchTerm.toLowerCase())
    );
  }
}
