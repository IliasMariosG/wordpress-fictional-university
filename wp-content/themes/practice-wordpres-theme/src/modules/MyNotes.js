import $ from 'jquery';

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote);
    $(".edit-note").on("click", this.editNote.bind(this));
    $(".update-note").on("click", this.updateNote.bind(this));
    $(".submit-note").on("click", this.createNote.bind(this));
  }

  // Custom methods here
  editNote(e) {
    var thisNote = $(e.target).parents("li");
    if (thisNote.data("state") == "editable") {
      // make read-only
      this.makeNoteReadOnly(thisNote)
    } else {
      // make editable
      this.makeNoteEditable(thisNote)
    }
  }

  makeNoteEditable(thisNote) {
    // Turn Edit button into a Cancel button
    thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
    // Remove readonly attributes from the relevant fields
    thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
    thisNote.find(".update-note").addClass("update-note--visible");
    thisNote.data("state", "editable")
  }

  makeNoteReadOnly(thisNote) {
    // Turn Edit button into a Cancel button
    thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
    // Add 'readonly' attributes from the relevant fields
    thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
    thisNote.find(".update-note").removeClass("update-note--visible");
    thisNote.data("state", "cancel")
  }

  deleteNote(e) {
    var thisNote = $(e.target).parents("li");
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
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

  updateNote(e) {
    var thisNote = $(e.target).parents("li");
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'POST',
      data: {
        'title': thisNote.find(".note-title-field").val(),
        'content': thisNote.find(".note-body-field").val()
      },
      success: (response) => {
        this.makeNoteReadOnly(thisNote);
        console.log('Success');
        console.log(response)
      },
      error: (response) => {
        console.log('Sorry');
        console.log(response)
      }
    });
  }

  createNote(e) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: {
        'title': $(".new-note-title").val(),
        'content': $(".new-note-body").val(),
        // by default 'status' is 'draft
        'status': 'publish'
      },
      success: (response) => {
        // empty out title and content
        $(".new-note-title", ".new-note-title").val('');
        $('<li> Imagine real data here </li>').prependTo("#my-notes").hide().slideDown();
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