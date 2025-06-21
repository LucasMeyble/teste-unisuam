import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  standalone: true,
  selector: 'app-home',
  imports: [FormsModule, RouterModule],
  templateUrl: './home.component.html',
})
export class HomeComponent {
  username = '';

  constructor(private router: Router) {}

  searchUser() {
    if (this.username.trim()) {
      console.log('Redirecionando para:', this.username);
      this.router.navigate(['/user', this.username]);
    }
  }
}
