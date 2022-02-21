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
    
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/121',
      type: 'DELETE',
      success: (response) => {
        console.log('Success');
        console.log(response)
      },
      error: (response) => {
        console.log('Sorry');
        console.log(response)
      }
    });
  }
}

export default MyNotes;