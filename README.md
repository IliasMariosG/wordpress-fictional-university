# WordPress Developer

---

<!-- <details><summary>CLICK ME (GitHub Magic)</summary>
<p>

#### GitHub does magic

  [Organizing information with collapsed sections](https://docs.github.com/en/github/writing-on-github/working-with-advanced-formatting/organizing-information-with-collapsed-sections)

</p>
</details> -->

A course on becoming a WordPress Developer by [Brad Schiff on Udemy](https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/)

## Set up dev environment

Install [Local by Flywheel](https://localwp.com/)

### Example

```php
$my name = 'Brad';
<h1> This page is all about <?php echo $myname ?></h1>
```

## PHP Functions

The heart and soul of WordPress and PHP

```php
<?php
  function greet($name, $favColor) {
    echo "<p>Hi, my name is $name and my favorite color is $favColor</p>";
  }
  greet('John', 'blue');
  greet('Maria', 'green');
?>

<h1><?php bloginfo('name'); ?>  </h1>
<p><?php bloginfo('description') ?> </p>
```

## PHP Arrays

Understanding arrays is what's going to let us start displaying actual dynamic WordPress content on the front end of our Web site, things like posts and pages.

## Loop in WordPress

- Posts

- Pages

  [dummy-page-123](http://practice-wordpress.local/dummy-page-123/) takes me to a screen with only the content for that one page. However, even though this screen only displays information for that one single page, we see that the headline is still a link, which means that this url and this screen is being powered by `index.php` instead of `single.php`. That's because WordPress only uses the `single.php` file for individual posts. For individual pages WordPress looks in our theme folder for a file named `page.php`. Back in our theme folder let's create a `page.php` file.

Depending on the url you visit, WordPress is going to use different files in your theme folder to control what you see on the screen.

The Loop is:

Doing something once for each item in a collection.

At the core of WordPress

- Header & Footer

  Set up a global header & footer

  Steps:
  
  - Load a `.css` file:

  - Inside the `head` element, type: `<?php wp_head(); ?>`

  - Create a `functions.php` file. Create (or define) a function that we chose tha name of. Within that function we called a wp function to point to the css file that we wanted to load. For the function to run, we type a WordPress function named `add_action()` that accepts two arguments. The second argument is the name of the function we want WordPress to call at a specific moment.'wp_enqueue_scripts' is how you say which moment that should be, which is also the The first argument. Finally:
  
    `add_action('wp_enqueue_scripts', 'university_files');`

    We don't add parentheses because we do not immediately call the functions, but it's up to WordPress when the precisely right moment is.
  
  WordPress has tons of moments or hooks.

- Black Admin Bar

  Add the black admin bar

  Steps:

  Jump in to to `header.php`. Move `</body>` and `</html>` closing tags into the very end of `footer.php`.

  Just before the `</body>` tag, we add `<?php wp_footer(); ?>`

## Design / Style

Integrate HTML and CSS into a living WordPress theme

```php
// functions.php

function university_files() {
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  }
  add_action('wp_enqueue_scripts', 'university_files');
  ```

Update HTML to look for the images in the right folder

- Initially it was

  ```html
  <!-- index.php. Notice `url` -->

  <div class="page-banner__bg-image" style="background-image: url(images/library-hero.jpg)"></div>
  ```

- Updating HTML by typing the full path

  ```html
  <!-- index.php. Notice `url`. We could type the full path... -->

  <div class="page-banner__bg-image" style="background-image: url(/wp-content/themes/practice-wordpres-theme/images/library-hero.jpg)"></div>
  ```

- Instead, we introduce the w/p function `get_theme_file_uri(singleArgument)`

  ```php
  // index.php. Notice how `url` changes to `get_theme_file_uri`

  url(<?php echo get_theme_file_uri('/images/library-hero.jpg')?>)
  ```

Connect to a local file

```php
// functions.php. The function declaration is omitted

wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/index.css'));
```

Connect to a site instead of a local file

```php
// functions.php

wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
```

Load a JS file with the w/p function `wp_enqueue_script()`

```php
// functions.php

wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
```

## Pages

Set up an interior page template

- Go to W/P admin page and create a new page with title 'About Us' and any content (for instance Lorem Ipsum)

- Publish

- Check Privacy Policy which has alreade been created by W/P for us

- Go to `page.php` and paste the HTML needed

- Check the [privacy policy page](http://practice-wordpress.local/privacy-policy/)

Generate a title tag for each screen

- Jump in to `functions.php` and add a new action.

  - The name of the WordPress event that we want to hook on to is:

  ```php
  add_action('after_setup_theme');
  ```

  - The second argument is just the name of a function that we are going to invent

  ```php
  add_action('after_setup_theme', 'university_features');
  ```

  ```php
  // functions.php
  function university_features() {
    add_theme_support('title-tag');
  }
  ```

Add links within header and footer theme files (Create links with PHP)

- Initialy it was

  ```html
  <div class="site-header__menu group">
    <nav class="main-navigation">
      <ul>
        <li><a href="/about-us">About Us</a></li>
    ...
  </div>
  ```

- We drop into PHP

  ```html
  <div class="site-header__menu group">
    <nav class="main-navigation">
      <ul>
        <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
    ...
  </div>
  ```

  where the php code can be found as an attribute inside the `<a>` element which is inside the `<li>` element

  ```php
  <?php echo site_url('/about-us') ?>
  ```

### Adjust Theme Templates to Account for Parent & Children Pages

Example:

Create two children pages under the About Us page

Steps:

- Go to W/Press admin area and create a new page titled Our History

- Under the Page menu, check the Page Attributes -> Parent Page. Click inside and choose 'About Us' (as the parent page)

- Publish

Repeat step for the 'Our Goals' page

Make the front end reflect those parent - child relationships

- Go to `page.php`

  ```html
  <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="#"><i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a> <span class="metabox__main">Our History</span>
          </p>
        </div>
        ...
  ```

- Between the first and second `<div>`, we jump into php:

  ```php
  <?php
    wp_get_post_parent_id(get_the_ID()); 
  ?>
  ```

  This line of code tells "get the ID of the current page we 're viewing and then wordpress we want you to use that number to look up the ID of its parent page"

Another example: Create a Privacy Policy child page

```php
  <?php
    get_permalink($theParent);
    Back to <?php echo get_the_title($theParent) ?>;
  ?>
  ```

### Why do some functions need echo while some others don't

As a rule of thumb, a function starting with `the_` echoes and outputs onto the page, while one with `get_` only returns a value and it's up to us to use that however we see fit

### Official WordPress Websites

1. [codex](https://codex.wordpress.org/)

2. [wordpress developer](https://developer.wordpress.org/)

### Child Page Link Menus

Add menu that has links to the applicable children

- Go to `page.php` anc create a new page titled

### Dynamic Navigation Menus

#### Create WordPress dynamic powered navigation menus and edit & maintain them from the WordPress admin appearance menu screen

```php
// functions.php
function university_features() {
    register_nav_menu('headermenuLocation', 'Header Menu location');
    add_theme_support('title-tag');
  }
```

Shine when hovering over with the mouse

```php
// header.php
<nav class="main-navigation">
  <?php
    wp_nav_menu(array(
      'theme_location' => 'headerMenuLocation'
    ));
  ?>
```

```php
// header.php
 <nav class="main-navigation">
    <ul>
      <li><?php if (is_page('about-us') or wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"' ?><a href="<
        ?php echo site_url('/about-us') ?>">About Us</a></li>
...
```

## Blog Section

Building the Blog aspect of the Web site

### Blog Listing Page

- Pages > New > Title: Home
- Pages > New > Title: Blog

  Both pages have an empty body

- Settings > Reading > Your homepage displays > Your latests posts (selected by default)

  - Select 'A static page (select below)'

  - Homepage or Front Page > (select) Home

  - Posts page > (select) Blog

Copy everything from `index.php` and paste to `front-page.php`. Then, delete everything from the `index.php` file.

- `index.php` will power the generic blog listing screen, whereas th STUFF MISSING

- STUFF MISSING

### Pagination (Blog Continued)

By default w/p shows the 10 most recent blog posts. If we have more than 10, we'd need pagination links

- WordPress Admin > Settings > Reading and and change the 'Blog pages show at most' option

- Back to php, this is how easy it it to create pagination links

  ```php
  //index.php

    echo paginate_links();
  ```

About the `single.php` template

- `single.php` is used for individual posts

- `page.php` is used for individual pages

- Copy STUFF MISSING from to `page.php` to `single.php`

- STUFF MISSING

### Blog Archives (archive.php)

See posts from certain categories, authors, date

`http://practice-wordpress.local/category/news/` and `http://practice-wordpress.local/author/{author_name}/` are archive screens examples. Now the moment, these author and category archive screens are being powered by `index.php` of our `theme` folder. At the end of the day, that's not the job of the `index` file. `index` is really just supposed to be a generic fallback, last line of defense insurance policy. `index` is never WordPress' first choice. WordPress would rather use an appropriate theme file depending on the url you you're visiting. In this case, the file would be `archive.php`.

So right now, let's go ahead and create an `archive.php` file and use it to set up relevant archive title. Headlines here like "Authored by Brad" or "Category Awards" instead of this generic "Welcome to our Blog" text.

- Create a new file named `archive.php` in our theme folder

- Copy everything from `index.php` to `archive.php`

  - On line 8 we're going to use php to create a title adjusted to the archive screen we see each time. Right now, it's hardcoded:

    ```html
    <!-- archive.php -->
    <h1 class="page-banner__title">Welcome to our blog!</h1>
    ```

  - After the changes, it's going to be:

    ```php
    <h1 class="page-banner__title"><?php if (is_category()) {
        single_cat_title();
      }
      if (is_author()) {
        echo "Posts by "; the_author();
      } ?></h1>
    ```

  - Setting up different `if` statements for every one of those situations could be exhausting. That's how we work around this:

    ```php
    <!-- archive.php -->
    <h1 class="page-banner__title"><?php the_archive_title(); ?></h1>
    ```

  - On line 10, we probably don't want to output the subtitle `<p>Keep up with the latest news.</p>` on every single archive screen. Let's call the brother or sister to the `the_archive_title()` function:

    ```php
    <!-- archive.php -->
      <?php the_archive_description(); ?>
    ```

### Custom Queries

In order to actually pull in the real dynamic two most recent blog posts, we are going to need to learn about something called custom queries.

On the opposite, there are normal or default queries. So far, WordPress has automatically queried for us depending on the particular url we're visiting.

Custom queries allow us to query whatever we want, wherever we want.

Whenever we want to create a new custom query, we begin by creating a variable. We could name our query, whatever we want to.Let's call it `$homepagePosts`. `$homepagePosts = new WP_Query();`. All we need to do within these parentheses is tell this class what type of content we're looking for or what do we want to query. We don't just want to include a simple parameter. Instead, we need to supply this class with an array of arguments. So within the parentheses, type out the word `array` and then give it its own set of parentheses. And then within the array parentheses, I like to drop down to a new line just to stay organized. And now we just create an associative array to tell this class what we're looking for.

Inside `<h2 class="headline headline--small-plus t-center">From Our Blogs</h2>`, on line 43:

```php
// front-page.php

<?php
  $homepagePostsQuery = new WP_Query(array(
    'posts_per_page' => 2
  ));
  

  while ($homepagePostsQuery->have_posts()) {
    $homepagePostsQuery->the_post(); ?>
     <li><?php echo get_the_title(); ?></li>;
  <?php } ?>
  
  // or
  
  while ($homepagePostsQuery->have_posts()) {
    $homepagePostsQuery->the_post();
    echo '<li>' . get_the_title() . '</li>';
  } ?>
```

For the styling:

```html
// front-page.php

<div class="full-width-split__inner">
  <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
  <?php
    $homepagePostsQuery = new WP_Query(array(
      'posts_per_page' => 2
    ));
    
    while ($homepagePostsQuery->have_posts()) {
      
      $homepagePostsQuery->the_post(); ?>
      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
          <span class="event-summary__month"><?php the_time('M');?></span>
          <span class="event-summary__day"><?php the_time('d') ?></span>
        </a>
        <div class="event-summary__content">
        
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php  the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
          <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
        </div>
      </div>
      
  <?php } wp_reset_postdata();
  ?>

  <p class="t-center no-margin"><a href="#" class="btn btn--yellow">View All Blog Posts</a></p>
</div>
```

- `wp_reset_postdata();` this function isn't always 100 percent necessary, especially if you're towards the bottom of a template file, but it's a really good habit to get into.

### Blog: Quick Edits & Improvements

Update button that reads 'View all Blog Posts'.

```html
<p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog Posts</a></p>
```

Update blog link up in the header navigation:

```html
// header.php
<li><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
```

- However, we want the 'Blog' text to stay lit up as a subtle yellow color to indicate that that's where you are.

  - We could say `if (is_home())` that will evaluate to true when you are on the generic blog listing homepage screen, however, that function will return false if you're on an individual blog post or a category archive screen.
  
  - We could try `is_single()` and that will evaluate to true on individual post screens or
  
  - We could try `is_archive()` for the author and category archive screens.
  
  - Let us use a neat way of covering all of our bases with just one condition check:

    ```php
    // header.php

    <?php
    if (get_post_type() == 'post')
    ?>
    ```

  - Out of the box, WordPress comes with posts and pages. A page is really just a post that has a post type that equals page and a traditional blog post obviously has a post type of post.

## Events Post Type

### Custom Post Types

That way we're not limited to only posts and pages. We can create custom post types named events, programs, professors and campuses.

Create an entry, or an item or a post for each event:

- Register or create a new post type inside `functions.php`

  - `add_action('init', 'university_post_types');`

  - `function university_post_types() {`

  - `register_post_type('event', array(
      'public' => true,
      'labels' => array(
        'name' => 'Events'
      )
    ));
  }`

  - `functions.php` is not the absolute best place to keep this custom post type code. Right, because we don't want access to our data to be reliant on a certain theme being activated. Instead of a theme this is probably a better use case for a plug in. However, when it comes to WordPress plug ins, they can easily be activated and deactivated. The best way of handling custom post types is by leveraging something in WordPress called Must Use Plugins. Must Use Plugins live in their own special dedicated folder, and you cannot deactivate them as long as the file exists in the Must Use Plugins folder:

    - Inside the `wp-content` folder, create a folder named `mu-plugins`. mu stands for must use. Inside that folder create a file named anything, e.g. `university-post-types.php`.

    - Cut `function university_post_types() {
    register_post_type('event', array(
      'public' => true,
      'labels' => array(
        'name' => 'Events'
      ),
      'menu_icon' => 'dashicons-calendar-alt'
    ));
  }

  add_action('init', `university_post_types');` from `functions.php` and paste that block of code and paste it in `university-post-types.php`.

  - Even if the owner of the website switches to a new theme or deactivates it, all of their plugins our code that makes the events post type possible, will still be loaded by WordPress.

- Back to the `labels` array:

  In the admin site, when I try to create a new event, you might have noticed towards the top it reads Add New Post, but I would prefer it say Add New Event:

  ```php
  // university-post-types.php

  // ... code omitted

  'name' => 'Events',
        'add_new_item' => 'Add New Event'
      ),
  ```

  On a similar note, if I try to edit one of my existing events, the headline reads 'Edit Post', but it would make sense if it said 'Edit Event' instead.

  ```php
  'edit_item' => 'Edit Event'
  ```

  A smaller detail that you might have noticed is if you hover over posts or pages in the sidebar, the first main option so you can see a list of all of the items to edit them, reads 'All Posts' or 'All Pages'. But for events, it doesn't say 'All Events', it just reads'Events'. So if you want to customize what that reads, back in the text editor, let's add a comma and a new line:

  ```php
  'all_items' => 'All Events'
  ```

  Finally, we add a comma and a new line and type: `'singular_name' => 'Event'`.

  For more information on the parameters of the  function `register_post_type` we can google the name of this function.

### Displaying Custom Post Types

Pull in event items into the home page or into any of our template files.

- `single.php` powers the blog. We create a `single-evnt.php` file that will power the events

```php
// university-post-types.php

function university_post_types() {
  register_post_type('event', array(
    'rewrite' => array(
      'slug' => 'events'
    ),
    'has_archive' => true,
```

- At the moment, the theme file that is powering the screen with the URL `http://practice-wordpress.local/events/` is `archive.php`. If we want a new theme file that's only responsible for the event archive, all we need to do is to creat a new file in the theme folder. The name of the file is `archive-event.php`. We want to call it archive dash and then whatever the name of our custom post type is.

Now, instead of just echoing out `site_url('/events')`, we'll use a different approach in case the slug changes in the future:

- So we change:

  ```php
  <a class="metabox__blog-home-link" href="<?php echo site_url('/events'); ?>">
  ```

- to:

  ```php
  <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
  ```

  by just saying the post type we're interested in

### Misc Updates

Handcrafted excerpt instead of using 18 words with the `trim_words()` function:

Change `<?php echo wp_trim_words(get_the_content(), 18)` to:

```php
<?php
  if (has_excerpt()) {
    the_excerpt();
  } else {
    echo wp_trim_words(get_the_content(), 18);
  }; ?>
```

- However, from a design perspective, we notice vertical gaps around the excerpt. Change `the_excerpt();` to `echo get_the_excerpt();`

- Regarding custom post types, we need to tell W/P that a post type should support excerpts:

```php
// university-post-types.php

register_post_type('event', array(
    'supports' => array('title', 'editor', 'excerpt')
```

Make events link work

```php
// header.php

<li <?php if (get_post_type() == 'event') echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('event') ?>">Events</a></li>
```

### Custom Fields

What date is the event going to take place on? (Not the date it was published). Our event post type should support custom fields:

- ```php
  // university_post_types.php
  
  function university_post_types() {
    <!-- ... -->
      'supports' => array(..., 'custom-fields'),
  }
  ```

- To view custom fields:

  Refresh the admin edit screen, in the top right corner click the three dots -> preferences -> panels -> additional -> check "Custom Fields"

- Custom field overview

  - inputs: "Name", "Value"

  - button: "Add custome Field"

- Two (Industry Standard) Custom Fields Solutions as Plugins:

  - Advanced Custom Fields (ACF)

  - CMB2 (Custom Metaboxes 2)

  - You can use on or the other. We' ll use ACF.

- ACF methodology

  - Delete `'custom-fields'` from the `supports` line in the `mu-plugins` (must use plugins) folder

  - wp admin, click Plugins -> Add New -> in the top right field search for "Advanced Custom Fields" and choose the one from Delicious Brains with more than 2 million active installations. Install and activate it.

  - A new option will be shown towards the bottom of the sidebar named "Custom Fields". Everything here is revolved around Group FIelds, so we' ll create a new one with a title of "Event Date".

So here we are, ready to answer the event date affair.

- Let's finish the AFC methodology first:

  - field label: Event Date

  - field name: event_date,

  - field type: Date Picker,

  - required: yes,

  - display format: as it is,

  - return format: Ymd

  - location -> rules: Show this field group if "Post Type" "is equal to" "Event"

  - up in the top right corner, click "Publish"

Let's edit an event again, e.g. Poetry Day:

- You can an "Event Date" field. If you click on that you're free to choose whatever date you want...and update

How to use that custom field data on the front end of our website:

```php
// front-page.php

<span class="event-summary__month"><?php 
  $eventDate = new DateTime(get_field('event_date'));
  echo $eventDate->format('M');
?></span>
<span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
```

### Ordering (Sorting) Custom Queries

Order Custom Queries by Custom Field Value

Learn how the retrieved and queried posts get ordered or sorted.

Order upcoming events alphabetically by their title

```php
// front-page.php

$homepageEventsQuery = new WP_Query(array(
  // retrieve all posts
  'posts_per_page' => -1,
  'post_type' => 'event',
  'orderby' => 'title',
  'order' => 'ASC',
```

Order upcoming events randomly

`orderby' => 'rand',`

Order upcoming events by created or published date

`'orderby' => 'post_date'`

Order upcoming events by event date

```php
// front-page.php

$homepageEventsQuery = new WP_Query(array(
  // retrieve all posts
  'posts_per_page' => -1,
  'post_type' => 'event',
  'meta_key' => 'event_date',
  'orderby' => 'meta_value_num',
  'order' => 'ASC'
```

- So we're saying we want to order things by the value of a piece of metadata, in this case, a meta or custom field.  if you set the order by to meta value, you need to be sure to add on another parameter named meta Key. And this is where we spell out specifically the name of the custom field that we're interested in. So obviously, remember, the name of the field is event underscore date.
Meta value is how we tell WordPress that we want to order by a meta key and meta value is well suited if you're sorting letters and words. But in this case, since we're going to be sorting numbersa date is just a set of numbers. Instead of `'meta_value_num'`.

Filter out past events. The answer is that we need to use something called a meta query

- Let's add another argument called `'meta_query'`. Then we're going to set that to equal an array within the array parentheses. The reason we give `'meta_query'` an array is because we are allowed to give it multiple conditions or things to check for. But then each one of those things that we're checking for should be an array of its own.

- We only need to check for one thing. We want to say only return posts if the event date is greater than or equal to today's date. We just need to give this inner array a few key parameters:

  ```php
  // front-page.php

  $homepageEventsQuery = new WP_Query(array(
    // retrieve all posts
    'meta_query' => array(
      array(
        // x: temproary placeholder
        'key' => x,
        'compare' => x,
        'value' => x
      )
    )
  ```

  - So now we just use these three parameters to basically create a sentence in plain English. That means only give us posts if the `key`, which is the custom field, which is the event date, is greater than or equal to (comparison operator for `compare`) today's date (`value`):

  ```php
  // front-page.php

  $homepageEventsQuery = new WP_Query(array(
    // retrieve all posts
    'posts_per_page' => -1,
    <!-- ... -->
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => date('Ymd')
      )
    )
  ```

  Now this code will work, but it never hurts to tell WordPress what type of values you're going to be comparing. So why don't we go ahead and add one more parameter here named `type` and let's set that equal `numeric` `'type' => 'numeric'`

  or finaly

```php
$today = date ('Ymd'); $homepageEventsQuery = new WP_Query(array(
  // retrieve all posts
  'posts_per_page' => -1,
  'post_type' => 'event',
  'meta_key' => 'event_date',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key' => 'event_date',
      'compare' => '>=',
      'value' => $today,
      'type' => 'numeric'
    )
  )

));
```

Takeaways:

- Introduction to this idea of ordering by something other than the published on date. We are ordering by a custom field.

- And then the other takeaway point for this lesson is that we can use meta queries to really have fine grained control over searching for particular values.

These are big concepts that we are going to practice and use again and again as we build out the programs, professors and campuses portions of the website

### Default URL based queries

We don't need to completely destory the default query `/events` that WordPress is going to make on its own based on the URL of the events archive screen.

`add_action('pre_get_posts')`

`pre_get_posts` meaning right before
we get the posts with the query

So this way, when WordPress calls our function and it passes along the WordPress query object (`$query`), we can now manipulate that object within the body of our function:

```php
function university_adjust_queries ($query) {
    //code here...
  }
```

- Let's target that query object:

  ```php
  function university_adjust_queries ($query) {
      $query
    }
  ```

- Let's look inside the object with `->`:

  ```php
  function university_adjust_queries ($query) {
      $query->
    }
  ```

- And it has a method, or a function, named `set()`:

  ```php
  function university_adjust_queries ($query) {
      $query->set()
    }
  ```

- And we need to give this set method two arguments.

  - The first argument is the name of a query parameter that we want to change:

    ```php
    function university_adjust_queries ($query) {
        $query->set('posts_per_page');
      }
    ```

  - The second argument is the value that you want to use:

  ```php
  function university_adjust_queries ($query) {
        $query->set('posts_per_page', '1');
      }
  ```

- And if I jump back to the website, you can see that now there's only one event per page and then we can use pagination to go to the next set of results and the next set. However, this is not limited to just the events. If I click "Blog" up in the header, we can see that the code we wrote is being applied universally to all queries. So we're just seeing one individual blog post and then we have to use pagination.
The code that we just wrote is so powerful that it even affects the backend admin portion of our website. So if I click on posts, we only see one item per page or if I click on events. We only see one.

In this case, we just want to customize the query for these events page, the events archive screen.

- So first and foremost, we only want this code to run if we are on the front end of our website. We don't want to manipulate the query on the backend admin portion of our website.

```php
function university_adjust_queries ($query) {
    if (!is_admin()) {
      $query->set('posts_per_page', '1');
    }
  }
```

```php
function university_adjust_queries ($query) {
    if (!is_admin() AND is_post_type_archive('event')) {
      $query->set('posts_per_page', '1');
    }
  }
```

So only if we're on the front end (we 're not in the admin)and only if we're on the archive for event

So let's say that our blog is back to normal. It's showing multiple posts. But our events archive is still listening to our query manipulation and just to play it safe, whenever I manipulate a default query, I always like to add on one more checks in the IF statement:

- So I say, and if the query that is being passed into our function, so dollar sign query and then I can look within it for a method named `is_main_query()`. **So this way we never accidentally manipulate a custom query**. This function will only evaluate to true if the query in question is the default url based query:

  ```php
  function university_adjust_queries ($query) {
      if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $query->set('posts_per_page', '1');
      }
    }
  ```

- This query manipulation will only run on our intended url

Back to our task at hand, we want to order by the event date instead of the published or created on date and exclude events in the past:

- Order by the event date. We'll use code from the `front-page.php` file, specifcally the custom query and manually set each parameter one by one:

  - The first argument is the query parameter that we want to target, `meta_key` and then the second argument is what you want to set it to.

  ```php
  function university_adjust_queries ($query) {
      if (...)) {
        $query->set('meta_key', 'event_date');
      }
  ```

  - Right below that, we're going to need to set another parameter. So we begin with our query object, look inside it and call the set method again and then you just rinse and repeat that process.
  So back in front page, the next parameter that we want to target is `order_by`

  ```php
  function university_adjust_queries ($query) {
      if (...)) {
        // ...
        $query->set('orderby', 'meta_value_num');
      }
  ```

  - Except we want them to be ordered in the opposite direction. We want the most rapidly approaching event first

  ```php
  function university_adjust_queries ($query) {
      if (...)) {
        // ...
        $query->set('order', 'ASC');
      }
  ```

  - Filter out past events

  ```php
  function university_adjust_queries ($query) {
      if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
      // Create $today variable
      $today = date ('Ymd');
      $query->set('meta_query', array(
        // filter out events from the past
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
      ));
  ```

### Past Events Page (Custom Query Pagination)

We will create a new page that only lists events that took place in the past because

"Add New" event from the admin sidebar named Past Events.
At this moment, the template file in our theme folder that's powering the screen `http://practice-wordpress.local/events/past-events/`is `page.php`. However, if we want to write custom code here to pull in a list of events that took place in the past, we are going to need a new unique special template file for this past events.

So, we create a new file called `page-past-events.php` or in general `page-name-of-slug.php`

### TO ADD MORE

- [ ] line above

## Programs

### Creating Relationships between Content

Goals:

- Create a new post type

- create a relationship between a certain program and a certain event

Programs page is being powered by `single.php`. We'll create a dedicated template file just for individual program posts

- `single-program.php`

Copy from `single-event.php` and paste to `single-program.php

Into the metabox change to

  ```php
  <a class="metabox__blog-home-link" href="<?php echo site_url('/programs'); ?>">
              <i class="fa fa-home" aria-hidden="true"></i> All Programs
            </a>
  ```

- The All Programs page or `http://practice-wordpress.local/programs/` or the URL-programs/ is powered by the generic `archive.php` file

- Let's crete a new file that is only responsible for the program's archive

  - `archive-program.php`

Copy from `archive-event.php` and paste to `archive-program.php

### Displaying Relationships (Front-End)

FROM HERE

When it comes to the relationship between an event and a program, we want it to be a two way street. The answer is the database. How do we communicate with the db? With the custom query:

```php
//single-program.php

    'type' => 'numeric'
  ),
  array(
    'key' => 'related_programs',
    'compare' => 'LIKE',
    'value' => '"' . get_the_ID() . '"'
  )
)
```

### Quick Program Edits

Set up programs link in the header navigation

- Headline that reads upcoming biology events

```php
//single-program.php

));

  echo '<h2>Upcoming ' . get_the_title() . ' Events</h2>';
  while($homepageEventsQuery->have_posts()) {
```

- Improve styling and formatting

```php
//single-program.php

  ));

  echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
  while($homepageEventsQuery->have_posts()) {
```

- Add extra vertical space

```php
//single-program.php

echo '<hr class="section-break">';
echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
```

Now, even programs that do not have associated events have a horizontal rule and  a headlnine

```php
//single-program.php

if ($homepageEventsQuery->have_posts()) {
  echo '<hr class="section-break">';
```

"Programs" link in the main header navigation

```php
//single-program.php

<li><a href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
```

Link stays lit up

```php
//single-program.php

li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"' ?>>
```

Link large hero blue button "Find Your Major" in homepage to "All Programs" page

```php
//front-page.php

<a href="<?php get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
```

## Professors

Goal

We will create a brand new post type for professors, learn how to associate an image with each post, learn about the WordPress native featured image or thumbnail image.
And even beyond that, we will learn how to create our own extra image fields using advanced custom fields.
We will even learn how to tell WordPress to automatically generate multiple sizes and aspect ratios of each photo that gets uploaded

### Professors Post Type

Create a brand new post type for professors

- Register post type in `university-post-types.php`

- Create a `single-professor.php` file

- Copy everything from `ingle-event.php` and paste to the newly created file

- Delete the entire metabox div

Establish a relationship between a professor post and a program post

- Adjust Related Program field group location so that it also displays if you're editing a professor post (By clicking or Add Rule Group)

- Go back to Professor Dr. Barksalot and add Biology as a related program

- Change `<h2>` to "Subject(s) Taught"

- On the [Biology](http://practice-wordpress.local/programs/biology/) program page we need to utput any professors that teach biology. So go to `single-program.php`:

```php
<section class="generic-content">
  <?php the_content() ?>
  </section>

  <section>
    <?php
      // Displays professors
      $relatedProfessorsQuery = new WP_Query(array(
        // retrieve all posts
        'posts_per_page' => -1,
        'post_type' => 'professor',
        // order by a custom field
        
        'orderby' => 'title',
        // end of order by a custom field
        'order' => 'ASC',
        'meta_query' => array(
          
          array(
            'key' => 'related_programs',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'
          )
        )
      ));

      if ($relatedProfessorsQuery->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
        while($relatedProfessorsQuery->have_posts()) {
          $relatedProfessorsQuery->the_post(); ?>
          <li>
            <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
            </a>
          </li>
        <?php }
      }
      wp_reset_postdata();

      $today = date('Ymd');
      $homepageEventsQuery = new WP_Query(array(
```

### Featured Image (Post Thumbnail)

Learn how to associate an image with a post (featured image)

We want to programmatically assign a one on one relationship between this post and an image

- enable featured iamges in our theme inside the `functions.php`

```php
function university_features() {
   ...
   add_theme_support('post-thumbnails');
}
```

- This alone will still not enable featured images for our professor post type. The code we just wrote will indeed enable featured images for blog posts. But when it comes to custom post types, within the `university-post-types.php` file where we register our different post types, we add a `thumbnail` in the professor post type:

```php
 // Professor Post Type
  register_post_type('professor', array(
    'supports' => array('title', 'editor', 'thumbnail'),
```

Now there is a "featured image" box in each professor's post page on the admin site. Then, uplaod a pic, related a program

- Format what is displayed on each professor page. Inside `single-professor.php`:

```php HTML and php
<div class="container container--narrow page-section">

  <section class="generic-content">
    // output image and content side by side
    <section class="row group">
      <aside class="one-third">
          // output the pic
          <?php the_post_thumbnail(); ?>
      </aside>

      <aside class="two-thirds">
      // output the main content
        <?php the_content(); ?>
      </aside>
    </section>
  </section>
```

- Format each subject page

  - Instead of just a plain text list, I think it would be nice if we pulled in the featured image for each professor And then overlay the transparent bit of text with their name on top of the image. Inside `single-program.php`:

```php HTML and php
<section>
  <?php
    // Displays professors
    $relatedProfessorsQuery = new WP_Query(array(
      'show_in_rest' => true,
      // retrieve all posts
      'posts_per_page' => -1,
      'post_type' => 'professor',
      // order by a custom field
      
      'orderby' => 'title',
      // end of order by a custom field
      'order' => 'ASC',
      'meta_query' => array(
        
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));

    if ($relatedProfessorsQuery->have_posts()) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
      
      echo '<ul class="professor-cards">';
      while($relatedProfessorsQuery->have_posts()) {
        $relatedProfessorsQuery->the_post(); ?>
        <li class="professor-card__list-item">
          <a class="professor-card" href="<?php the_permalink() ?>">
            // image of the professor
            // the source attr. point towards the URl of the featured image
            <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>" alt="">
            // name overlapped or overlaid on top of the image
            <span class="professor-card__name"><?php the_title(); ?></span>
          </a>
        </li>
      <?php }
      echo '</ul>';
    }
    wp_reset_postdata();

    $today = date('Ymd');
```

- Size of image

  - See images inside the `wp-content` folder -> `uploads` -> `{date}`. Then, inside `functions.php`:

  ```php
    ...
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 400, 650, true);
  }
  ```

- Plugin to retroactively create new sizes of the images is "regenerate thumbnails" (Admin site -> Plugins - Add new -> ...type to search)

- Tools -> regenerate thumbnails -> click "regenerate 3 featured thumbnails"

### Featured Image Sizes & Cropping

Use custom resized images on the front-end

- inside `single-professor.php`

```php HTML and PHP
<aside class="one-third">
  // give the image nickname as argument. That's it
  <?php the_post_thumbnail('professorPortrait'); ?>
```

- however, the subject screen uses the high resolution pic. Let's change that. Inside `single-program.php`

```php HTML and PHP
<img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
```

- Crop images

  - Search for "manual image crop tomasz" plugin in the admin dashboard

  - If for example, we edit Dr. Meowsalot post, over in the featured image area if we click on the featured image, there a new option called "crop image"

  - Now, to crop the image in the subject screen, we choose the ProfessorLandscape and

  - To crop the image in the professor scree, we choose the ProfessorPortrait

### Page Banner Dynamic Background Image

Goals:

Make top banner area dynamic

Set things up so that each post and each page can upload its own unique background image, instead of the default fallback beach or ocean photo

- Create custom field to allow the user to upload an image file. Admin dashboard -> Custom Fields -> Add New -> type "Page Banner"

  - we want this group to contain two fields, one field for the subtitle (Field Label: Page Banner Subtitle, Field Type: Text) and another field for the image (Field Label: Page Banner Image, Field Type: Image).

  - Location. Show this field group if post is equal to Post or post is not equal to Post so that the banenr is applicable to all pages

- Inside `functions.php`

```php
add_image_size('pageBanner', 1500, 350, true);
```

- Admin dashboard -> Professors -> edit Dr. Barksalot: type something for "Page Banner Subtitle" and upload an image for "Page Banner Background Image"

- Inside `single-professor.php` work on pulling in the dynamic subtitle and background image in the text editor.

```php
<div class="page-banner__bg-image" style="background-image: url(<?php
        $pageBannerImage = get_field('page_banner_background_image');
        echo $pageBannerImage['url'] ?>);">
      </div>
      <div class="page-banner__content container container--narrow">
        
        <h1 class="page-banner__title"> <?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p><?php the_field('page_banner_subtitle'); ?></p>
          <!-- <p><?php print_r($pageBannerImage); ?></p> -->
        </div>
      </div>
```

- If we want to use a custom size image, then:

```php
echo $pageBannerImage['sizes']['pageBanner']
```

- If we want more fine grained control, we edit the pic on the adim dashboard, in the professor page -> Page Banner Background Image -> Crop Image -> PageBanner (instead of the Thumbnail)

### Reduce Duplicate Code - Create our own Function

```php
// functions.php
// the body of the function has been cut from single-professor.php

function pageBanner($args) {
    // php logic lives here
    ?>
    <div class="page-banner">
      <!-- <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div> -->
      <div class="page-banner__bg-image" style="background-image: url(<?php
        $pageBannerImage = get_field('page_banner_background_image');
        echo $pageBannerImage['sizes']['pageBanner'] ?>);">
      </div>
      <div class="page-banner__content container container--narrow">
        
        <h1 class="page-banner__title"> <?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p><?php the_field('page_banner_subtitle'); ?></p>
          <!-- <p><?php print_r($pageBannerImage); ?></p> -->
        </div>
      </div>
    </div>
  <?php
  }

// single-professor.php becomes
while(have_posts()) {
    the_post();
    pageBanner();
  ?>
```

Provide a default title

```php
// functions.php
function pageBanner($args) {
    // php logic lives here
    if (!($args['title'])) {
      $args['title'] = get_the_title();
    }
    ?>

<h1 class="page-banner__title"> <?php echo $args['title']; ?></h1>
```

Do the same for subtitle (Provide a default subtitle)

```php
// functions.php
// ...
if (!($args['subtitle'])) {
  // parameter of get_field is the name of ACF name
  $args['subtitle'] = get_field('page_banner_subtitle');
}

// down below
the_field('page_banner_subtitle');
// becomes
echo $args['subtitle'];

// if we delete the 'subtitle' => 'This is the subtitle' in page.php and referesh the about-us page we'll see the custom subtitle
```

Fall-back behavior for background photo

### Using pageBanner() Function to Reduce Duplication

```php
// in various .php files...
<?php
  get_header();
  pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.'
  ));
?>
```

### `get_template_part()` to Reduce Duplication

Goal

Right now we're displaying events to four different pages - homepage, All Events (/events), Past Events (/past-events) and in each program's page (/program/{program-name})

So our goal for this lesson is to move or consolidate this code into its own individual file, and then we can just call and recycle that file wherever we need to.

```php
// front-page.php

while($homepageEventsQuery->have_posts()) {
  $homepageEventsQuery->the_post(); ?>
  // cut from here..
  <div class="event-summary">
    <a class="event-summary__date t-center" href="#">
      <span class="event-summary__month"><?php 
        $eventDate = new DateTime(get_field('event_date'));
        echo $eventDate->format('M');
      ?></span>
      <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
    </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
      <p><?php
          if (has_excerpt()) {
            echo get_the_excerpt();
          } else {
            echo wp_trim_words(get_the_content(), 18);
          }; ?>  <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
    </div>
  </div>
  // ..till the <div> on the line above
<?php }
?>

// then...

while($homepageEventsQuery->have_posts()) {
            // remove the php closing tag
            $homepageEventsQuery->the_post(); ?>
            x
          // and the php opening tag
          <?php }
          ?>

// and it becomes...
while($homepageEventsQuery->have_posts()) {
  $homepageEventsQuery->the_post();
  get_template_part();
}
?>

```

- Homepage:

```php
while($homepageEventsQuery->have_posts()) {
  $homepageEventsQuery->the_post();
  get_template_part('./template-parts/content', 'event');
}
```

- `/events`:

```php
<?php
  while (have_posts()) {    
    the_post();
    get_template_part('./template-parts/content-event');
  }
```

- `/page-past-events`:

```php
while ($pastEventsQuery->have_posts()) {    
  $pastEventsQuery->the_post();
  get_template_part('./template-parts/content-event');
}
```

- `programs/{program-name}`:

```php
// single-program.php
while($homepageEventsQuery->have_posts()) {
  $homepageEventsQuery->the_post();
  get_template_part('./template-parts/content-event');
}
```

## JavaScript Preparation

No notes to add

## Campus

### Campus Post Type

We'll create a new post type names Campus

### Campus Map on Front-End

```php
// single-campus.php

$mapLocation = get_field('map_location');
  echo $mapLocation['lat'];?>
```

### Campuses Continued

If for each individual campus we had  a section that said "programs available at this campus". In order to create a relationship between a program and a campus, we're going to need to create a new custom field:

- go to admin

- add new custom field "Related Campus(es)

- Edit Math program to related to Downtown West Campus

```php
// single-campus.php

// <!-- utilise single-program.php -->
// ... other code

      <section class="generic-content">
        <?php the_content();
         $mapLocation = get_field('map_location');
        ?>
        <div class="acf-map">
        // <!-- no need for the while loop because we are already on the isngle permalink for this campus-->
            <div class=marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
              <h3><?php the_title(); ?></h3>
              <?php echo $mapLocation['address']; ?>
            </div>
          // <!-- no need for pagination links here -->  
        </div>
      </section>
      
      <section>
        <?php
          // Displays programs available
          $relatedProgramsQuery = new WP_Query(array(
            'show_in_rest' => true,
            // retrieve all posts
            'posts_per_page' => -1,
            'post_type' => 'program',
            // order by a custom field
            
            'orderby' => 'title',
            // end of order by a custom field
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          if ($relatedProgramsQuery->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs available at this campus</h2>';
            
            echo '<ul class="min-list link-list">';
            while($relatedProgramsQuery->have_posts()) {
              $relatedProgramsQuery->the_post(); ?>
              <li>
                <a href="<?php the_permalink() ?>">
                  <?php the_title(); ?> 
                </a>
              </li>
            <?php }
            echo '</ul>';
          }
          wp_reset_postdata();

          // homepage events query
          // if ($homepageEventsQuery->have_posts()) { ...

         
    </div>
    <?php }

  get_footer();
?>

```

```php
// single-program.php

// ...code about homepageEventsQuery

// Campus related to the subject/program
wp_reset_postdata();
$relatedCampuses = get_field('related_campus');
if ($relatedCampuses) {
  echo '<hr class="section-break">';
  echo '<h2 class="headline headline--medium">'.  get_the_title() . ' is Available at These Campuses:<h2>';
  echo '<ul class="min-list link-list">';
    foreach ($relatedCampuses as $campus) { ?>
      <li>
        <a href="<?php
          echo get_the_permalink($campus); ?>">
          <?php echo get_the_title($campus); ?>
        </a>
      </li>
    <?php } ?>
  </ul>
<?php } ?>
```

## Live Search Results Powered by JavaScript

### Live Search

Give the search icon functionality

Live (search) is just another way of saying real time or on the fly or in the moment.

Inside src/modules/ create a file called `Search.js`

```js
class Search {
  constructor() {
    alert('Hello, I am a search');
  }
}

export default Search;
```

Inside src/index.js

```javascript
import Search from "./modules/Search"
// ...
const search = new Search();
```

### Opening and Closing the Search Overlay

when someone clicks on this search icon in the top right corner, we want to respond by opening up a full screen, semi transparent overlay with a text field where users can begin typing in what they're looking for

First write the HTML to control what the overlay should look like. Inside `footer.php`:

### to complete

Regarding the "x" or closing icon we want to use JavaScript so that when you click this close icon, we remove this active class from the search overlay (`search-overlay--active`) so then it becomes invisible again.

```js
// Search.js

import $ from 'jquery';

class Search {
  // 1. describe and create or initiate our object
  constructor() {
    // this.openButton = document.getElementsByClassName("fa fa-window-close search-overlay__close");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close")
    this.searchOverlay = $(".search-overlay");
    this.events();
    // this.myI = document.querySelector("i");
  }
  
  // 2. events
  // console.log(openButton);
  // openOverlay(openButton)
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeoverlay.bind(this));
  }
  // 3. methods (function, action...)
  openOverlay() {
  //   myVar.onclick(alert("hi"))
    this.searchOverlay.addClass("search-overlay--active");
  }

  closeoverlay() {
  //   "d"
  this.searchOverlay.removeClass("search-overlay--active");
  }
}

export default Search;
```

### Preventing the text Field Suggesitons Pop-up

- [ ] to add?

### Keyboard Events in JS (Search Overlay Continued)

Keyboard shortcut to open the overlay

```js
// Search.js

// ...

events() {
  // ...
  $(document).on("keydown", this.keyPressDispatcher.bind(this));
}

// 3. methods
keyPressDispatcher(e) {
    
  if (e.keyCode == 83) {
    this.openOverlay();
  };
}

openOverlay() {
  $("body").addClass("body-no-scroll");
}
```

Keyboard shortcut to close the overlay

```js
// Search.js

// ...other code

// 3. methods
keyPressDispatcher(e) {
  // ... if for keyCode == 83
  
  if (e.keyCode == 27) {
    this.closeoverlay();
  }
}

closeoverlay() {
  $("body").removeClass("body-no-scroll");
}
```

Preventing key from endlessly running

- `"keydown"` is firing multiple times per second if you just keep holding down on the key

- Write some code to only close the overlay if it's currently open and you can only open the overlay if it's currently closed. The appropriate method will be called once as needed. In this way, we never risk overloading or freezing a Web browser

- ```js
  // Search.js

  //tweak constuctor
  constuctor() {
    // ...
    this.isSearchOverlayOpen = false;
  }

  // 3. methods (function, action...)
  keyPressDispatcher(e) {
    if (e.keyCode == 83 && (!(this.isSearchOverlayOpen)))
      //...
    }
    if (e.keyCode == 27 && this.isSearchOverlayOpen) {
      // ...
    }
  }

  openOverlay() {
    // ...
    this.isSearchOverlayOpen = true;
  }

  closeOverlay() {
    this.isSearchOverlayOpen = false;
  }
  ```

- This way if someone press and holds they key it only runs once

### Managing Time in JS

For example, when someone starts searching for "Biology", we don't want to send a search request when all they've typed in is the letter "B". So we don't want to send a search request as soon as someone starts or stops typing. Instead, Why don't we wait until they've paused or stopped typing for maybe 800 milliseconds or a full second?
So, for example, when they type in B, that would start a timer, but then if they type in another letter, it would reset the timer and would just continue on like that until they indeed finish typing and pause.

```js
// Search.js

//tweak constuctor
constuctor() {
  // ...
  this.searchFieldInput = $("#search-term");
  // ...
}

// 2. Events
events() {
  // ...
  this.searchFieldInput.on("keydown", this.typingLogic.bind(this));
}

// 3. methods (function, action...)
// ...

openOverlay() {
  // ...
  this.isSearchOverlayOpen = true;
}

closeOverlay() {
  // ...
  this.isSearchOverlayOpen = false;
}

typingLogic() {
  clearTimeout(this.typingTimer);
  this.typingTimer = setTimeout(function() {console.log("This is a timeout test");}, 2000);
}
```

### Waiting / "Loading" Spinner Icon

We will learn how to talk to the WordPress database and retrieve real content in real time on the fly.

After we type something in the search field, let's practice outputting real HTML content right below the area of the overlay

- `footer.php`

```php
s
- [ ] to add?
```

```js
// if any field is not currently focused, this will evaluate to true.
if ( ... && !$("input, textarea").is(':focus'))
```

```js
//current state

import $ from "jquery";

class Search {

  // 1. Describe and create or initiate our object
  constructor() {
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
      this.closeoverlay();
    }
  }
  
  openOverlay() {
  
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass('body-no-scroll');
    console.log("Our open method just run");
    this.isSearchOverlayOpen = true;
  }

  closeOverlay() {
  
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
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
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        /* if search field value is completely empty
        empty out the results section */
        this.searchResultsSection.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchFieldInput.val();
  }

  getResults() {
    /* As soon as the line of code below runs (.html),
    then the spinner will no longer be visible. */
    this.searchResultsSection.html("Imagine real search results here");
    // ...so spinner is set to false
    this.isSpinnerVisible = false;
  }
}

export default Search;
```

## WP REST API (AJAX)

### Load WP Content with JS

Send a request to the WP server or database

Use JavaScript to programmatically send a request to the URL in the background in real time, and then we can use this data however we see fit in our code.

```js
import $ from "jquery";

class Search {

  // 1. Describe and create or initiate our object
  constructor() {
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
      this.closeoverlay();
    }
  }
  
  openOverlay() {
  
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass('body-no-scroll');
    console.log("Our open method just run");
    this.isSearchOverlayOpen = true;
  }

  closeOverlay() {
  
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
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
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        /* if search field value is completely empty
        empty out the results section */
        this.searchResultsSection.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchFieldInput.val();
  }

  getResults() {
    // Send out a request to a url
    $.getJSON('http://practice-wordpress.local/wp-json/wp/v2/posts?search=' + this.searchFieldInput.val(), function(results) {
      alert(results[0].title.rendered);
    }) 
  }
}

export default Search;
```

### Generating HTML Based on JSON

Inside `Search.js`, we delete the pop-up. We want to show the results as an HTML

- However, `this` refers to the `getJSON()` method

  ```js
  getResults() {
      // Send out a request to a url
      $.getJSON('http://practice-wordpress.local/wp-json/wp/v2/posts?search=' + this.searchFieldInput.val(), function(results) {
        // this refers to .getJSON because that's what executed the function
        this.searchResultsSection.html('Imagine results here')
      }) 
    }
  ```

  What we can do so that `this` points to our main search object?
  We can either use `.bind(this)` right after the mention of the anonymous function (`function(results) { ...}.bind(this))`) or use ES6 arrow function:

  ```js
  function(results) {
    // code here
  }
  //becomes
  results => {
    // code here
  }

  ```

#### It finally becomes

```js
getResults() {
    // Send out a request to a url
    $.getJSON('http://practice-wordpress.local/wp-json/wp/v2/posts?search=' + this.searchFieldInput.val(), results => {
      // this refers to .getJSON because that's what executed the function
      this.searchResultsSection.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        <ul class="link-list min-list">
          <li><a href=${results[0].link}">${results[0].title.rendered}</a></li>
        </ul>
      `)
    }) 
  }

    // by working with template literal...
    this.searchResultsSection.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        <ul class="link-list min-list">
          ${results.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
        </ul>
      `)
```

### Conditional Logic within Template Literal

What if a search has no results?

- In JS we are not allowed to use `if` statements within a template literal

- We can use ternary operator though

```js
this.searchResultsSection.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        ${results.length == 0 ? 'No results mathing your search' : '<ul class="link-list min-list">'}
          ${results.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
        ${results.length == 0 ? '' : '</ul>'}
      `);
```

- Make the spinner reappear when I push a new key for a new search

```js
// ...
  `);
  this.isSpinnerVisible = false;
})
// ...
```

Make the API URL relative instead of absolute

```php
// functions.php

function university_files() {
  // ...
  wp_localize_script('main-university-js', 'universityData', array(
      // if you right-click the homepage > View Page Source, down at the bottom you'll see the universityData object with a property of `root_url` giving 'http://practice-wordpress.local'
      'root_url' => get_site_url()
    ));
}
```  

- Also,

```js
// Search.js

getResults() {
    // Send out a request to a url
    // delete 'http://practice-wordpress.local' and replace it with the `root_url` property
    $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' // ...
    // ...
```

### Quick Misc Edits

Quick Search Edits

At the moment, the main overlay section and text input live in `footer.php`. Let's move them to `Search.js`

```js
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

// and at the top of the constructor, call the function
constructor() {
  /* The reason we need to do this at the very beginning of our constructor is because otherwise these elements
  won't even exist yet */
  this.addSearchHTML();
  // ...
}
```

Change timer

```js
// inside typingLogic()
this.typingTimer = setTimeout(this.getResults.bind(this), 750);
```

Empty out text input after each search

```js
// inside closeOverlay()
this.searchFieldInput.val('');
```

Search immediately without having to click inside the text field

```js
// inside openOverlay()
setTimeout(()  => this.searchFieldInput.focus(), 301);
```

- [ ] *CHECK IF TODO*

### Synchronous vs Asynchronous (Part 1)

The synchronous way

```js
getResults() {
  // Send out a request to a url
  $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchFieldInput.val(), postResults => {
    $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchFieldInput.val(), pageResults => {
      var combinedResults = postResults.concat(pageResults);
    
      // this refers to .getJSON because that's what executed the function
      this.searchResultsSection.html(`
        <h2 class="search-overlay__section-title">General Information</h2>
        ${combinedResults.length == 0 ? 'No results mathing your search' : '<ul class="link-list min-list">'}
          ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
        ${combinedResults.length == 0 ? '' : '</ul>'}
      `);
      this.isSpinnerVisible = false;
    })
  }) 
}
```

### Synchronous vs Asynchronous (Part 2)

The asynchronous way

- `when().then(argument)` (`argument`=anonymous function we want to run once all data inside `when()` is ready)

  ```js
  getResults() {
    // Send out a request to a url
    $.when(
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchFieldInput.val()),
      $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchFieldInput.val())
      ).then((resultsPosts, resultsPages) => {
      
        var combinedResults = resultsPosts[0].concat(resultsPages[0]);
        // this refers to .getJSON because that's what executed the function
        this.searchResultsSection.html(`
          <h2 class="search-overlay__section-title">General Information</h2>
          ${combinedResults.length == 0 ? 'No results mathing your search' : '<ul class="link-list min-list">'}
            ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
          ${combinedResults.length == 0 ? '' : '</ul>'}
        `);
        this.isSpinnerVisible = false;
    }); 
  }
  ```

## Customising the REST API

### REST API: Add New Custom Field

What if we don't see everything in this data that we want or what if we want to add a new custom field to this raw JSON data?

- {title of the post} by {author name}

```php
// functions.php
function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() { return get_the_author();}
  ));
}
```

```js
// Search.js
// code omitted
getResults() {
  // ...
  ${combinedResults.map(...</a>${item.type == 'post' ? ` by ${item.authorName}` : ''}</li>`)
}
```

We learnt how to add new properties to the raw JSON data that W/P sends back to us

### REST API: Add New Custom Route (URL)

Learn how to create our own brand new completely custom rest API url

- We create a folder `inc` inside our theme folder, a file `search-route.php` inside `inc`

```php
<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'universitySearchResults'
  ));
}

function universitySearchResults() {
  return 'Congrats, you created a route.';
}
?>
```

- In the address bar, type `http://practice-wordpress.local/wp-json/university/v1/search`

### Create your own raw JSON data

```php this is an info string line
function universitySearchResults() {
  $professors = new WP_Query(array(
    'post_type' => 'professor'
  ));
  $professorResults = array();
  while($professors->have_posts()) {
    $professors->the_post();
    array_push($professorResults, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink()
    ));
  } 
  return $professorResults;
}
```

### WP_Query and Keyword Searching

```php
// after 'post_type' => 'professor'
's' => sanitize_text_field($data['term'])
```

### Working with Multiple Post Types

```php
// inside $mainQuery = new WP_Query(array(
  'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
));
  $mainResults = array(
    'blogsPages' => array(),
    'professors'=> array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );
  while($mainQuery->have_posts()) {
    $mainQuery->the_post();
    if (get_post_type() == 'post' OR get_post_type() == 'page') { 
      array_push($mainResults['blogsPages'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
    if (get_post_type() == 'professor') { 
      array_push($mainResults['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
    if (get_post_type() == 'program') { 
      array_push($mainResults['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
    if (get_post_type() == 'event') { 
      array_push($mainResults['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
    if (get_post_type() == 'campus') { 
      array_push($mainResults['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
  } 
  return $mainResults;
}
```

## Combining Front-End & Back-End

### Three-column Layout for Search Overlay

Update front-end JS to use new custom API url

- `getResults()` made two separate JSON requests, one for posts and one for pages. We've now created our own custom API URL that returns data for all six post types.

```js
getResults() {
    $.getJSON(
      universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchFieldInput.val(), 
      (dataFromJSONRequest) => {
      this.searchResultsSection.html(`
        <div class="row">
          <div class="one-third">
            <h2 clas="search-overlay__section-title">General Information</h2>
            ${dataFromJSONRequest.blogsPages.length == 0 ? 'No general information matching your search' : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.blogsPages.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.authorName}` : ''}</li>`).join('')}
            ${dataFromJSONRequest.blogsPages.length ? '</ul>' : '' }
          </div>
          <div class="one-third">
            <h2 clas="search-overlay__section-title">Programs</h2>
            ${dataFromJSONRequest.programs.length == 0 ? `No programs matching your search. <a href="${universityData.root_url}/programs">View all programs</a>` : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${dataFromJSONRequest.programs.length ? '</ul>' : '' }
            <h2 clas="search-overlay__section-title">Professors</h2>
            ${dataFromJSONRequest.professors.length == 0 ? 'No results matching your search' : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.professors.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.authorName}` : ''}</li>`).join('')}
            ${dataFromJSONRequest.professors.length ? '</ul>' : '' }
          </div>
          <div class="one-third">
            <h2 clas="search-overlay__section-title">Campuses</h2>
            ${dataFromJSONRequest.campuses.length == 0 ? `No campuses matching your search. <a href="${universityData.root_url}/campuses">View all campuses</a>` : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
            ${dataFromJSONRequest.campuses.length ? '</ul>' : '' }
            <h2 clas="search-overlay__section-title">Events</h2>
            ${dataFromJSONRequest.events.length == 0 ? 'No results matching your search' : '<ul class="link-list min-list">'}
            ${dataFromJSONRequest.events.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.authorName}` : ''}</li>`).join('')}
            ${dataFromJSONRequest.events.length ? '</ul>' : '' }
          </div>
        </div>
      `);
       this.isSpinnerVisible = false;
      // dataFromJSONRequest
    });
  }
```

### Custom Layout & JSON based on Post Type

#### Professors Column

```js
<h2 clas="search-overlay__section-title">Professors</h2>
${dataFromJSONRequest.professors.length == 0 ? 'No professors matching your search' : '<ul class="professor-cards">'}
${dataFromJSONRequest.professors.map(item => `
  <li class="professor-card__list-item">
    <a class="professor-card" href="${item.permalink}">
      <img class="professor-card__image" src="${item.image}">
      <span class="professor-card__name">${item.title}</span>
    </a> 
  </li>`).join('')}
  ${dataFromJSONRequest.professors.length ? '</ul>' : '' }
```

#### Campuses Column

```js
<h2 clas="search-overlay__section-title">Campuses</h2>
${dataFromJSONRequest.campuses.length == 0 ? `No campuses matching your search. <a href="${universityData.root_url}/campuses">View all campuses</a>` : '<ul class="link-list min-list">'}
${dataFromJSONRequest.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
${dataFromJSONRequest.campuses.length ? '</ul>' : '' }
```

#### Events Column

```js
<div class="one-third">
  <h2 clas="search-overlay__section-title">Campuses</h2>
  ${dataFromJSONRequest.campuses.length == 0 ? `No campuses matching your search. <a href="${universityData.root_url}/campuses">View all campuses</a>` : '<ul class="link-list min-list">'}
  ${dataFromJSONRequest.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
  ${dataFromJSONRequest.campuses.length ? '</ul>' : '' }
  <h2 clas="search-overlay__section-title">Events</h2>
  ${dataFromJSONRequest.events.length == 0 ? `No events matching your search. <a href="${universityData.root_url}/events">View all events</a>` : ''}
  ${dataFromJSONRequest.events.map(item => `
  // copied from content-event.php and edited accordingly
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
```

Also, in `search-route.js`:

```php
if (get_post_type() == 'event') {
  // date-related code copied from content-event.php
  $eventDate = new DateTime(get_field('event_date'));
  $description = null;
  // if-else statement copied from content-event.php
  if (has_excerpt()) {
    $description = get_the_excerpt();
  } else {
    $description = wp_trim_words(get_the_content(), 18);
  };
  array_push($mainResults['events'], array(
    'title' => get_the_title(),
    'permalink' => get_the_permalink(),
    // add month, day & description attributes
    'month' => $eventDate->format('M'),
    'day' => $eventDate->format('d'),
    'description' => $description
  ));
}
```

### Search Logic that's Aware of Relationships

#### Add a new query to search overlay results that will pull in profesor based on their relationship to a program (hard-coded)

In `search-route.js`:

```php
// after the 'while' loop
$programRelationshipsQuery = new WP_Query(array(
    'post_type' => 'professor',
    'meta_query' => array(
      // name of the advanced custom field we want to look within
      'key' => 'related_programs',
      'compare' => 'LIKE',
      'value' => '"105"'
    )
  ));
  while($programRelationshipsQuery->have_posts()) {
    $programRelationshipsQuery->the_post();
    if (get_post_type() == 'professor') { 
      array_push($mainResults['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        // first argument value (0): current post
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    };
  }
  // remove duplicates
  $mainResults['professors'] = array_unique($mainResults['professors'], SORT_REGULAR);
  return $mainResults;
```

### Search Logic that's Aware of Relationships (Part 2)

#### Edit professor and program relationship query and make it dynamic

TODO

### Completing our Search Overlay

Campuses are a bit different to professors and events (the direction of the relationship). On the admin page -> Campuses -> select any campus, we can see that it doesn't contain a field where you can relate it to a program. Instead, each program post gets related to a campus. We've set the math program to be related to the Downtown West campus

We want the title and permalink for the related campus, not the program. Thus, in `search-route.js`::

```php
array_push($mainResults['campuses'], array(
  'title' => get_the_title($campus),
  'permalink' => get_the_permalink($campus),
));
```

### Search Feature without jQuery

#### Differences

Select an element

- jQuery

  `$("#css-like-selector")`

- JS

  `document.querySelector(css-like-selector)` (selects the first instance of the selector)

Select all elements that matter

- jQuery

  `$(".element")`

- JS

`document.querySelectorAll(".selector")` (returns an array or a node lisr of alla elements that match the selector selectors)

## Non-JS Fallback Traditional Search

### Traditional WordPress Searching (Part 1)

In the address bar, type:

`http://practice-wordpress.local/?s=biology`

The search result screen is being powered by index.php of our theme folder

We can't expect visitors to know how to type the above in the address bar. For this reason, we'll create a new page and a new form in that page for visitors to type whatever they need to search for

 `http://practice-wordpress.local/search/` currently powerd by page.php

 We'll create a new theme file, `page-search.php`, only for `/search`

 then, we'll modify the `page.php` content, after we copy and paste everything to `page-search.php`

 Now this search form page doesn't need to have any actual WordPress body content, so why don't we delete this

`<?php echo site_url('/'); ?>`

This will generate the home page you url for our WordPress installation

`<?php echo esc_url(site_url('/')); ?>`

  At this point, we've told the form to add `s=asdssd` onto the root of the url instead.

  Also, method="GET". If we set this to post, then whatever the visitor types into our field would not get added at the end of the url

Now, navigation:

  let's adjust this top right search icon so that if JavaScript is disabled, it takes you to `/search`
  
  TODO

### Traditional WordPress Searching (Part 2)

Goal: Format search results

The search results results screen is powered by `index.php`. Create a `search.php` file, copy from `index.php` and paste to `search.php`

TODO

## User Roles and Permisions

Goals

- Permissions
- Security
- CRUD user-specific content

### User Roles & Permisions

#### Create a customer user role that can only manage the event post type

- In the admin, search for, install and activate Member - Membership & User Role Editor Plugin

- Members menu in the left-hand side bar: Members > Roles -> Add New -> "Event Planner"

- `mu-plugins/univerity-post-types.php`, inside the event post type add:

  ```php
    // creates new unique capabilities for event
    'capability_type' => 'event',
    // enforce and require these permissions
    'map_meta_cap' => true,
  ```

- Then, refresh admin and actually add the new role. Also, grant permsissions to the newly creatd "Events"

- Admin again, Users > Edit User coworkerone > Roles > deselect Editor and Select Event Planner

- Back in the private window, if I refresh the page, I can only see Events

- Normal admin, Members > Roles > Administrator > Events to grant event permissions to the administrator too!

#### Multiple Roles for the Same User

- `mu-plugins/univerity-post-types.php`, inside the event post type add:

  ```php
    // creates new unique capabilities for event
    'capability_type' => 'campus',
    // enforce and require these permissions
    'map_meta_cap' => true,
  ```

- Members menu in the left-hand side bar: Members > Roles -> Add New -> "Campus Manager"

- Back in the private window, if I refresh the page, I can only see Campuses and Events

- Normal admin, Members > Roles > Administrator > Campuses to grant event permissions to the administrator too!

### Open Registration

#### Sign up to the site

A new account will be assigned to "Subscriber" role

- Admin panel > Settings > General > Membership: Enable "Anyone can register" (User Default Role: "Subscriber")

#### When a user is logged in

- A logout button is shown
- A gravatar is shown

#### Subcriber is directed to the front end page

Right now they are directed to their dashboard

- `functions.php`:

  ```php
  add_action('admin_init', 'redirectSubsToFrontend');

  function redirectSubsToFrontend() {
    $ourCurrentUser = wp_get_current_user();

    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 
    'subscriber') {
      wp_redirect(site_url('/'));
      exit;
    }
  }
  ```

#### Hide top admin bar for subscribers

Work in `functions`

### Open Registration (Part 2)

#### Make Login button working

In `header` file, update the `href` value after the `else`:

- `echo wp_login_url()`

#### Get Sign Up button working

In `header` file, update the second `href` value after the `else`
`themes/practice-wordpres-theme/header.php`

#### Customize the WordPress login screen so that it's not branded with the big WordPress logo

- The logo - header url -, once clicked, directs to the official WordPress page

  In `functions`:

  ```php
  // Customise Login screen
  add_filter('login_headerurl', 'ourHeaderUrl');

  function ourHeaderUrl() {
    return esc_url(site_url('/'));
  }
  ```

- Update styling:

  In `functions`, all we have to do is apply css:

  ```php

  function ourLoginCSS() {
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
  }
  ```

- Change header title "Powered by WordPress" to th name of the site:

  In `functions`:

  ```php
  add_filter('login_headertitle', 'ourLoginTitle');

  function ourLoginTitle() {
    return get_bloginfo('name');
  }
  ```

## User Generated Content

### "My Notes" Feature

#### Create an orange My Notes button

Add a new page "My Notes"

Create a unique page template, currently powered by `page.php`

Name the new file `page-my-notes.php`

#### Direct user manually entering the `/my-notes` url when they are not logged in to the homepage

in `page-my-notes`:

```php
if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
  }
```

#### Create a new custom post type named Notes

in `university-post-types`:

```php
// Note Post Type
register_post_type('note', array(
'supports' => array('title', 'editor'),
// notes are visible only to the user
'public' => false,
// show in admin dashboard user interface
'show_ui' => true,
'show_in_rest' => true,
'labels' => array(
  'name' => 'Notes',
  'add_new_item' => 'Add New Note',
  'edit_item' => 'Edit Note',
  'all_items' => 'All Notes',
  'singular_name' => 'Note'
),
'menu_icon' => 'dashicons-welcome-write-blog'
));
```

#### Create two new notes from the admin back end

title 1: Biology Lecture #4

content 1: Today I watched biology and learnt a lot..

title 2: Math Lecture #1

content 2: Math class was great today. I learnt blah blah

`page-my-notes.php`:

```php
<div class="container container--narrow page-section">
  <ul class="min-list link-list" id="my-notes">
    <?php
      $userNotes = new WP_Query(array(
        'post_type' => 'note',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));

      while ($userNotes->have_posts()) {
        $userNotes->the_post(); ?>
        <li>
          <input class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>" type="text">
          <textarea class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
        </li>
      <?php
      }
    ?>
  </ul>
</div>
```

#### Create 'Edit' and 'Delete' buttons

The two `span` elements in `page-my-notes.php`

### "My Notes" Front-end Part 1

Goal: Edit and delete posts (notes) right from the front end of our website

### "My Notes" Front-end Part 2

Goal: Communicate with WP from the front end. When we click the `Delete` button how can we tell WordPress to delete a specific post? The answer is sending the right request to the REST API

`MyNotes.js`:

```js
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
     console.log($().jquery;)
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + 'wp-json/wp/v2/note/121',
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
```

### Delete Posts with the REST API

### Edit/Update Posts with the REST API

Feature: Once you click the edit button, then it turns into a cancel button. If you click the cancel button, then that would remove the animated border and also make it so these fields are read only once again

Feature: When you click the blue Save button it sends off a request to the WP REST API

### Creating New Notes

Feature: Create brand new posts by using the rest API. Add a form that users can fill out to create a brand new note post

The default post status when you create a post through the REST API is "draft". We can change the status from the admin dashboard and manually adjust that. But we can also do it programmatically.

### Creating New Notes (Part 2)

### Note Permission and Security (Part 1)

Feature: Give basic subscriber role users permission to create and manage their own notes

Steps:

`university-post-types`, edit Note post type

Admin dashboard, grant permissions for 'Notes' to admin and subscriber

Feature: Privacy. Only the creator or the author of note should be able to view it

##### Manually

Right now anyone can visit the url `http://practice-wordpress.local/wp-json/wp/v2/note/` and see newly created notes

We will leverage a WP native feature of private content:

Visit the admin dashboard -> Notes -> click the newly created note -> Status & Visibility -> Visibility -> Change to "Private"

- To do the same for all Notes: table nav (Bulk Actions, Edit, Move to Trash) -> Select Edit -> Apply -> in the box that shows up -> change status to "Private"

#### Programmatically

In `functions` file we create a `makeNotePrivate()` function to force note posts to be private on the server side, despite them having a `status` of `publish` in `MyNotes.js`, that is on the client side).

### Note Permission and Security (Part 2)

Admin dashboard -> Roles -> Subscriber -> Edit -> Notes -> Remove grant for delete_published_notes and edit_published_notes. Then update. Explanation: Now that we've set things up so that note posts will always be private, that means they will never actually be considered published

About Unfiltered HTML

By default, if you check the roles -> General in the admin dashboard the "Unfiltered HTML" is unchecked for every user role but the admin one.

Even though subscribers are not allowed to post unfiltered HTML by default, they are allowed to post basic HTML. We overcome this with the use of `sanitize_text_field` and `sanitize_textarea_field`

### Per-User Post Limit

### jQuery Free MY Notes

TODO

## Like or "Heart" Count for Professors

### Let Users "Like" or "Heart" a Professor (Part 1)

Add a little box with a heart icon and then a number indicating how many likes a professor has received

Set things up so that you need to be logged in with a subscriber count in order to add your like to the count

Implement custom logic so that each user account can only add one like, but they can click the heart button again to toggle or remove their original like

This feature it's a great exercise to learn how to set up your own custom rest API endpoints

- Visual aspect in `single-profesor` file:

```html
<aside class="two-thirds">
  <span class="like-box">
    <i class="fa fa-heart-o" aria-hidden="true"></i>
    <i class="fa fa-heart" aria-hidden="true"></i>
    <span class="like-count">3</span>
  </span>
  <?php the_content(); ?>
</aside>
```

- Data aspect: Create a new custom post type

  Author of a like post will be the user doing the liking

  First, we'll work in the back-end

  An ACField needed - Liked Professor ID

### Let Users "Like" or "Heart" a Professor (Part 2)

Set up custom rest API endpoints for our two like actions

### Creating custom POST and DELETE endpoints

TODO

### Programmatically Create a Post

TODO

### Enforce Limit of One Like Per User/Teacher Combo

**Goal**: Set things up so that you need to be logged in with a user account in order to create a like. We also need to set up the logic so that each user account can only create one like per professor

### Completing the LikeBox

Feature: Only logged in users can create a like

Feature: One like per professor

### Completing the Likebox

Feature: Update JavaScript so that when you do successfully add a like post, the likebox count and heart update in real time on the fly so that you don't need to manually refresh the page.

Feature: If you click the box again, we will set up the server side to delete or remove a like

### jQuery-free Likebox

TODO
Have not done that yet

## Going Live: Deploying our WordPress Site

The act of copying or moving or pushing a website up onto the web is commonly referred to as deploying

## Extra Credit Challenges & Topics

### Make Homepage Slideshow Dynamic

Register post type

Dynamically add title, subtitile, link text, link value and image(**pending**)

## Plug-in Development

### Introduction to Plug-in Development

A guided tour of plug-in development. Core building blocks and the most comment features in order to build plug-ins

#### Overview

The first chapter will be about php. This will cover sort of the traditional skeleton or building blocks of creating a new plug in.

The next chapter will be about JavaScript. So it will create a new block type for the WordPress or Gutenberg block editor. Along the way we will learn a little bit about React. But we need to remember that this is a course about WordPress not react, meaning we won't cover React as in-depth and as slow the pace as we would in my course. That's entirely dedicated to react. OK, and then in the final of these three plugin chapters, we'll talk about databases specifically when you're plugging needs to store data. We'll talk about when it makes sense to use the WordPress built in custom post type versus when it makes more sense to use or create your own custom database table

In the first chapter, the plug-ins discussed are word count and word filter

In the second chapter, the plug-ins discussed are two new blocks, quick question and professor callout

In the plug-in DB chapter a new sections called Pet Adoption is added (100,00 items (pet custom post types) need to be stored in the DB). In this chapter will discuss in detail when it makes sense to use custom post types for your plug in data needs and when it makes sense to implement your own custom database table. Also, there is a form to add a name and then it will randomly generate all of the other attributes about the pet and add it too the DB

### Let's Create our First Plug-in

How and where to create a plug-in in the first place?

E.g. Dynamically add a sentence to the end of a blog post for the permalink or single view of posts

Inside `wp-content`, create a new directory `out-first-unique-plugin`. Inside the latter, create a file `out-first-unique-plugin.php`

```php
<?php

/*
  Plugin Name: Test Plugin
  Description: A plugin to exercise
  Version: 1.0
  Author: Perforation
*/

?>
```

In the admin side bar, plugins, we can see the newly created plugin. Activate it

Right now, the plug-in doesn't do anything. Details in `out-first-unique-plugin.php`

### Adding a Settings Page For Our Plugin

A big part of what plugins do isn't just the feature that they bring to the table, but it's also letting the user adjust settings and preferences. This is where a plug in setting screen or an admin setting screen comes into play

Our very first task is simply to learn how to add a link in the admin settings menu to a new custom page that we are creating

### (...continued) Settings API

Settings From and Settings API

Our real goal here is just to permanently save the user's preferences into the database.

So let's begin by looking at the WordPress database and seeing where it stores settings and option values.

So how do we look at our database?

Well, if you're using the local WP or local by flywheel application, just click on the current site that you're running. Then in this area you'll see a database tab. You can click on that and then just click on this "open adminer" button. Once you click on that, it should open a new tab that looks something like this, and this is the database for your WordPress website.

Over here we see the different tables. The one that I want to draw attention to right now, though, is called options. So let's click onto that options table.

And then instead of just showing the structure for the table, let's click this "select data" link.

### Finishing Settings Form

Display Location value remembers the selected value after reloading the page

### Actually Counting the Words, Characters, Read Time

We only really need to change or filter the content if a) you're on a single blog post screen and b) if the user has any of the three checkboxes checked

### Translations / Localization (for PHP)

admin link under the "Settings" menu that says "Word Count"

create Text Domain, Domain Path to the top of `our-first-unique-plugin.php`

add code to tell WP to load our text domain files -> within the constructor, add action

add Loco Translate plugin -> admin sidebar > Loco Translate > Running Plugins > click on Test Plugin

- create template

- create translation
  
  new language

  - language option: choose a language

  - Location option: Choose Author

  - Click Start Translating

### Admin Sub-Menu

- a) learn how to have a completely custom settings page with all of our own code, both
the HTML and the PHP

- b) the other thing that's unique about this plug in is we're actually getting a top level menu, with a sub-menu, in the admin dashboard sidebar

- c) we're actually going to learn how to have our own SVG icon instead of a generic dash icon

The first page of the plugin is not going to be built using the WordPress form generator functions. We will build it ourselves, will also learn how to apply a little bit of CSS if we want to. And perhaps most importantly, we're going to write the PHP that actually handles the submission and processing of this form.

- Create `index.php` and add code

- Activate plugin in the dashboard via 'Plugins'

### Custom Admin Menu Icon

Provide custom SVG icon istead of the built-in dashicon

Build out our own HTML page

### Alternative: Manualy Handling Admin Form Submit

TODO

## Plugin Development: Blocks, Gutenberg & React

Use JS to create new custom block types

### Introduction to JS plugin Development

Multiple Choice Quiz Plugin

1) Register plugin `/new-block-type-paying-attention/index.php`

2) Activate plugin: Admin dashboard > Plugins > Activate

3) Register custom block type in `/new-block-type-paying-attention/test.js`

### Introduction to JSX

-

### Block Type Attributes

Add an attribute to a block type

### Output of the Block (Part 1)

What our blog outputs or saves

If we change the HMTL structure, save the file `index.js` and see the post, we see an error

`This block contains unexpected or invalid content.`

The `deprecated` property comes into play. However, by making changes to the `save` function in the `index.js` file, it does not allow us to see any change on the screen. To do that, we need to actively open the post in the admin edit screen and then resave or update it. In case the number of posts is large, e.g. hundreds or thousands, then this approach is not useful.
This is where a dynamic block comes into play with the use of `null`

### Output of the Block (Part 2)

We no longer just need to load a JavaScript file with this exact action hook instead of just loading a file, we now want to actually register a block type from within PHP. So we do want to use a different action hook

## Plugin: Multiple Choice Block TYpe

### Starting the Multiple Choice Block Type

### Styling the Block

### Event handling & Updating Block Attributes

Store the data that user types into the field

Have the JSX start changing when the user tries to add a second, third, or fourth answer

### Focus New Field for Immediate Typing

Whenever clicking the "Add another answer button" the new text field is automatically focused so we can immediately begin typing

- **Not yet implemented**

### Setting Up the Correct Answer

Add a new feature that points towards the correct index or item in our array

### How to Use React on the Front-end of WordPress

Front-end JS for a Block Type

### Passing Block Data from PHP into JS/React

### Letting Users Click On (Guess) an Answer

### Attention to Detail

### A Note About Animations / Transitions in React

Note from the instructor:

> In the following lesson you may have noticed that instead of dynamically adding / removing content from JSX / DOM I'm just letting all of the content be present the entire time and using CSS classes to make it visible or invisible.
>
> I did this for the sake of simplicity, and because this is a course about WordPress and not React. If you are interested in learning more about React, and would want to write conditional JSX to actually add/remove content from the DOM at the appropriate time (without it appearing or disappearing abruptly in 1 millisecond without an animation/transition) I recommend checking out the popular React community package called React Transition Group.
>
> Thanks!
>
> Brad

### Let Admin Choose Background Color of Block

Adding custom options to the admin block type

With PanelBody, PanelRow and InspectorControls we can create a right-hand options area

With `react-color` we can integrate a third-party color picker. It's not neccessary, but it's done to show how easy the process is

### Block Text Alignment & Block Preview

Finish the Quiz Block Type

- Choose text alignment

## Plugin: Featured Professor

Create a relationship between two pieces of content

### Starting Our Featured Professor

**Steps**:

- Set up a featured professor block type

- Add drop-down menu with hard-coded values

- Third step

  Update dropdown menu with `professorFeaturedID`

  Let WP remember the user's selected option (currently "1", "2", "3" as fake professors ID)

### Loading a List of Professors

Work with `select` element of the drop-down menu to trade out the hard-coded values with an actual list of all of our professor posts by using JS

Steps:

- Add a text saying "Loading..."

- Second step

  Make use of `useSelect` from `@wordpress/data`

  Get rid of the hard-coded values and load the list of professors dynamically (`.map`). Also, now the post ID is stored in the database (you can check by going into the database)

### Displaying Professor Info

Query and display information about the selected professor

We're starting from the public front-end output

Steps:

Edit `renderCallback` function

  When user as already selected one of the professors

  When user has just inserted this block type and they have not selected a value yet

(Code Organisation) Separate HTML output from featured-professor.php

Query professor post and show title & content

Add image as a background image (instead of an inline `img` element)

Show the related programme the profesor teaches

Add full stop and commas when programs are more than one

Show the link to the professor's detail screen

### Professor Preview in Editor (Part 1)

### Professor Preview in Editor (Part 2)

Load HTML preview for a specific professor we choose on the editor screen

### Control Post Meth with Block Type

Create a relationship between a blog post any of its featured professors

We're going to create the following record in the database:

A meta_key called featured_professor (`featuredprofessor` in the `index.js` file), a post_id having a value of the blog post that is featuring the professor and the mate_value being the value of the ID of the proffessor

Update the meta

Register the meta to store the udpates in the database

### Add related Posts to Professor Detail Page

Display any related posts on the professor detail screen

<<<<<<< HEAD
### Translations / Localisation (For JavaScript)

=======
>>>>>>> 8f947349e33c88106673c85b8592978a4b72ac7c
In the main `featured-professor` file:

Add text domain, domain path, load the plugin text domain in the `onInit()` function

In the `index.js` file:

Replace the "Select a professor." text inside the `<option>` element

In the admin dashboard:

Use loco translate to create a template for the plug in:

- Loco Translate > Settings > Scan JavaScript files with extensions: > Set it to "js"

Connect JS and the WP translation as a whole

## Plugin Development: Custom SQL Database Table

How to store our data in the database and code the custom database solution

### Understanding the Pros and Cons of the "Post" Paradigm

Steps:

Activate pet adoption plugin (admin dashboard)

Begin to populate the pet collection with a bit of data

### Creating our Own Custom Table

First, deactivate the custom pet adoption (Custom Post Type) plugin

Create a separate table calles pets:

Steps:

Activate Pet Adoption (New DB Table) plugin

Insert new pet into the table
<!-- 
### Querying Our Table

### Building Dynamic Queries (Part 1)

### Quick Note about PHP Arrays

### Building Dynamic Queries (Part 2)

### Create Pet from Front-end

### Delete Pet from Front-end -->
