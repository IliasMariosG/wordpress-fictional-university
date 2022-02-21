import $ from 'jquery';

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote);
  }

  // Custom methods here
  deleteNote() {
    alert('You clicked the delete button');
  }
}

export default MyNotes;