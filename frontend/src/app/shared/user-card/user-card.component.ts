import { Component, Input } from '@angular/core';
import { GithubFollowing } from '../../core/models/github-user.model';

@Component({
  selector: 'app-user-card',
  templateUrl: './user-card.component.html',
  styleUrls: ['./user-card.component.css']
})
export class UserCardComponent {
  @Input() user!: GithubFollowing;
}
