import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent {
  title = 'angular';
  email = 'sample email';
  name = '';
  list = [{ name: 'test' }];
  display = false;

  handleSubmit(input: string) {
    this.name = input;
    this.list.push({ name: this.name });
  }

  displayList() {
    this.display = !this.display;
  }
}
