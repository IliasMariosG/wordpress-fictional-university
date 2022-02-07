import $ from "jquery";

class Search {

  // 1. Describe and create or initiate our object
  constructor() {
    /* The reason we need to do this at the very beginning of our constructor is because otherwise these elements
    won't even exist yet */
    this.addSearchHTML();
    // this.openButton = document.getElementsByClassName("fa fa-window-close search-overlay__close");
    this.searchResultsSection = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close")
    this.searchOverlay = $(".search-overlay");
    this.searchFieldInput = $("#search-term");
    this.events();
    this.isSearchOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;

  }
  
  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchFieldInput.on("keyup", this.typingLogic.bind(this));
  }
  
  // 3. Methods (function, action...)
  keyPressDispatcher(e) {
    // open overlay
    if (e.keyCode == 83 && (!(this.isSearchOverlayOpen)) && !$("input, textarea").is(':focus')) {
      this.openOverlay();
    };

    // close overlay
    if (e.keyCode == 27 && this.isSearchOverlayOpen) {
      this.closeOverlay();
    }
  }
  
  openOverlay() {
  
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass('body-no-scroll');
    setTimeout(()  => this.searchFieldInput.focus(), 301);
    console.log("Our open method just run");
    this.isSearchOverlayOpen = true;
  }

  closeOverlay() {
  
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.searchFieldInput.val('');
    console.log("Our close method just run");
    this.isSearchOverlayOpen = false;
  }

  typingLogic() {
    
    if (this.searchFieldInput.val() != this.previousValue) {
      clearTimeout(this.typingTimer);
      // if the search field value is not blank
      if (this.searchFieldInput.val() != '') {
        if (!this.isSpinnerVisible) {
          this.searchResultsSection.html('<section class="spinner-loader"></section>')
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        /* else if search field value is completely empty
        empty out the results section */
        this.searchResultsSection.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchFieldInput.val();
  }

  getResults() {
    $.getJSON(
      universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchFieldInput.val(), 
      (dataFromJSONRequest) => {
      this.searchResultsSection.html(`
        <div class="row">
          <div class="one-third">
            <h2 clas="search-overlay__section-title">General Information</h2>
            ${dataFromJSONRequest.blogsPages.length == 0 ? 'No general information matching your search.' : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.blogsPages.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.authorName}` : ''}</li>`).join('')}
            ${dataFromJSONRequest.blogsPages.length ? '</ul>' : '' }
          </div>
          <div class="one-third">
            <h2 clas="search-overlay__section-title">Programs</h2>
            ${dataFromJSONRequest.programs.length == 0 ? `No programs matching your search. <a href="${universityData.root_url}/programs">View all programs</a>` : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${dataFromJSONRequest.programs.length ? '</ul>' : '' }
            <h2 clas="search-overlay__section-title">Professors</h2>
            ${dataFromJSONRequest.professors.length == 0 ? 'No professors matching your search.' : '<ul class="professor-cards">'}
            ${dataFromJSONRequest.professors.map(item => `
              <li class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                  <img class="professor-card__image" src="${item.image}">
                  <span class="professor-card__name">${item.title}</span>
                </a>
              </li>`).join('')}
              ${dataFromJSONRequest.professors.length ? '</ul>' : '' }
          </div>
          <div class="one-third">
            <h2 clas="search-overlay__section-title">Campuses</h2>
            ${dataFromJSONRequest.campuses.length == 0 ? `No campuses matching your search. <a href="${universityData.root_url}/campuses">View all campuses</a>` : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${dataFromJSONRequest.campuses.length ? '</ul>' : '' }
            <h2 clas="search-overlay__section-title">Events</h2>
            ${dataFromJSONRequest.events.length == 0 ? `No events matching your search. <a href="${universityData.root_url}/events">View all events</a>` : ''}
            ${dataFromJSONRequest.events.map(item => `
            <div class="event-summary">
              <a class="event-summary__date t-center" href="${item.permalink}">
                <span class="event-summary__month">${item.month}</span>
                <span class="event-summary__day">${item.day}</span>
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
              </div>
            </div>
            `).join('')}
            ${dataFromJSONRequest.events.length ? '</ul>' : '' }
          </div>
        </div>
      `);
       this.isSpinnerVisible = false;
      // dataFromJSONRequest
    });
  }

  addSearchHTML() {
    $("body").append(`
    <section class="search-overlay">
      <section class="search-overlay__top">
      <!-- Anything that lives within this section will be horizontally centered on the screen.   -->
        <section class="container">
          <!-- Create a large search icon -->
          <!-- Since we are using the font awesome library, <i> is how you can create an icon. -->
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"> </i>
          <label for="search-term"></label>
          <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
          <!-- Create an X or closing icon -->
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"> </i>
        </section>
      </section>

      <section class="container">
        <section id="search-overlay__results">
          
        </section>
      </section>
    </section>
    `);
  }
}

export default Search;