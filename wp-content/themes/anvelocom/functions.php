<?php


// Constants

define("PAGE_ABOUT_US", 'Date firma');

define("CATEGORY_META", '467');
define("CATEGORY_PRODUS", 'produs');
define("CATEGORY_REDUCERI", 'reduceri');
define("CATEGORY_BESTSELLERS", 'cele-mai-vandute');




define("PAGE_ANVELOPE", 'categoryanvelope-auto-offroad');
define("PAGE_JENTI", 'jante-auto-aluminiu-si-tabla');
define("PAGE_TUNING", 'tuning-auto-powertuning');
global $SPECIAL_PAGES;
$SPECIAL_PAGES = array(PAGE_ANVELOPE, PAGE_JENTI, PAGE_TUNING);


define("CATEGORY_ANVELOPE", 'anvelope-auto-offroad');
define("CATEGORY_JENTI", 'jante');
define("CATEGORY_TUNING", 'tuning');
global $SPECIAL_CATEGORIES;
$SPECIAL_CATEGORIES = array(CATEGORY_ANVELOPE, CATEGORY_JENTI, CATEGORY_TUNING);


define("META_ANVELOPE_DIMENSION", 'Dimensiune janta');
define("META_ANVELOPE_LATIME", 'latime');
define("META_ANVELOPE_INALTIME", 'inaltime');
define("META_ANVELOPE_BRAND", 'brand');
define("META_ANVELOPE_PROFIL", 'profil');
$FILTERS_ANVELOPE = array(META_ANVELOPE_LATIME, META_ANVELOPE_INALTIME, META_ANVELOPE_DIMENSION, META_ANVELOPE_BRAND, META_ANVELOPE_PROFIL);
$FILTERS_ANVELOPE_LABELS = array('Latime anvelopa', 'Inaltime anvelopa', 'Diametru janta', 'Marca', 'Profil');
$FILTERS_ANVELOPE_LABELS2 = array('Toate latimile', 'Toate inaltimile', 'Toate dimensiunile', 'Toate marcile', 'Toate profilurile');

$FILTERS_JENTI = array();
$FILTERS_JENTI_LABELS = array();
$FILTERS_JENTI_LABELS2 = array();

$FILTERS_TUNING = array();
$FILTERS_TUNING_LABELS = array();
$FILTERS_TUNING_LABELS2 = array();

global $FILTERS;
$FILTERS = array($FILTERS_ANVELOPE, $FILTERS_JENTI, $FILTERS_TUNING);
$FILTERS_LABELS = array($FILTERS_ANVELOPE_LABELS, $FILTERS_JENTI_LABELS, $FILTERS_TUNING_LABELS);
$FILTERS_LABELS2 = array($FILTERS_ANVELOPE_LABELS2, $FILTERS_JENTI_LABELS2, $FILTERS_TUNING_LABELS2);





// Filters


// Returns an array of values to use in a filter
// - $filter_meta, the meta field to look for
// - $articles, the list of posts where to search for thei meta tag
function get_filter_values($filter_meta, $articles) {
  $ret = array();
  if ($articles) {
    foreach ($articles as $article) {
      $ret = array_merge($ret, get_filter_value($filter_meta, $article));
    }
  }
  return array_filter(array_unique($ret));
}

// Returns post meta values for a given meta tag
// - $filter_meta, the tag
// - $article, the post
function get_filter_value($filter_meta, $article) {
  $ret = array();
  if ($article) {
    $ret = get_post_meta($article->ID, $filter_meta);
  }
  return $ret;
}

// Generates a class for each article to use with the filters
// - $filters, an array of meta tags
function get_article_class($filters, $article) {
  $klass = array();
  
  foreach ($filters as $filter_meta) {
    $klass = array_merge($klass, get_filter_value($filter_meta, $article));
  }
  
  $klass = array_map("string_to_classname", $klass);
  return $klass;
}




// Get posts, categories, and so on

function get_posts_from_category($category_slug, $how_many) {
  $c = get_category_by_slug($category_slug);
  if ($c) {
    $category_id = $c->term_id;
    
    $p = get_cat_ID(CATEGORY_PRODUS);
    return get_posts(array(
      'category__and' => array($category_id, $p),
      'posts_per_page' => $how_many,
    ));
  }
}

function get_category_url($category_slug) {
  $category_id = get_cat_ID($category_slug);
  return get_category_link($category_id);
}


function get_children_categories($parent_slug) {
  $c = get_category_by_slug($parent_slug);
  if ($c) {
    $category_id = $c->term_id;
    
    return get_categories(array(
      'child_of' => $category_id,
    ));
  }
}

// Checks in which main category this post belongs
// - returns the category slug
function get_post_main_category_slug($post) {
  $post_categories = wp_get_post_categories($post->ID);
  $post_category_slugs = array();
  
  foreach($post_categories as $c) {
	  $cat = get_category($c);
	  $post_category_slugs[] = $cat->slug;
  }
  
  global $SPECIAL_CATEGORIES;
  $main_category = array_intersect($post_category_slugs, $SPECIAL_CATEGORIES);
  return $main_category[0];
}


// Check which filters / meta tags apply for a post based on it's main category
function get_post_filters($main_category) {
  global $SPECIAL_CATEGORIES;
  global $FILTERS;
  
  $index = array_search($main_category, $SPECIAL_CATEGORIES);
  return $FILTERS[$index];
}

// Get product dimension
// - ie 265/55/r18
function get_product_dimension($post, $main_category) {
  $filters = get_post_filters($main_category);
  
  // Merge filters into a string
  $filter_string = get_article_class($filters, $post);
  $filter_string = implode('/', $filter_string);
  return $filter_string;
}


// Returns similar products based on product parameters / filters
// - $dimension is created from meta fields / filters like '265/55/R18';
function get_similar_posts($post, $main_category, $dimension) {
  $filters = get_post_filters($main_category);
  $posts = get_posts_from_category($main_category, -1);
  
  $ret = array();
  foreach ($posts as $p) {
    $klass = get_article_class($filters, $p);
    $klass = implode('/', $klass);
    
    if ( ($klass == $dimension) && ($p->ID != $post->ID)) {
      $ret[] = $p;
    }
  }
  
  return $ret;
}




/* Get anvelope brands */
function get_anvelope_brands() {
  $c = get_category_by_slug(CATEGORY_ANVELOPE);
  $category_id = $c->term_id;
  
  return get_categories(array(
    'child_of' => $category_id,
  ));
}


/* Get the latest anvelopes */
function get_anvelopes($how_many) {
  $c = get_category_by_slug(CATEGORY_ANVELOPE);
  $category_id = $c->term_id;
  
  $p = get_cat_ID(CATEGORY_PRODUS);
  return get_posts(array(
    'category__and' => array($category_id, $p),
    'posts_per_page' => $how_many,
  ));
}


/* Get the content of About Us */
function get_date_firma() {
  $about_us = get_page_by_title(PAGE_ABOUT_US); 
  $page_data = get_page($about_us);
  return $page_data->post_content;
}







// Get post images
// - the largest images are retrieved
// - returns an array of urls
function get_post_images($post_id) {
  $attachments = get_post_attachments($post_id);
  
  $images = array();
  
  // The featured image must be get separately
  // - if the featured image is already added to the Media Library the duplicates will be filtered out on return
  $images[] = get_post_featured_image_url($post_id, 'full');
  
  if ($attachments) {
    foreach ($attachments as $attachment) {
      $image = wp_get_attachment_image_src($attachment->ID, 'full');  
      $images[] = $image[0];
    }
  }
  
  return array_unique($images);
}


/* Get a posts featured image url 
  - The image size can be specified with Wordpress default parameters like thumbnail, medium, large, full
  - The medium is resized to 700x700 
  - The 700x700 size was choosen to be optimized for mobile and small tablets
*/
function get_post_featured_image_url($post_id, $size = array(700, 700)) {
  
  if ($size == 'medium') {
    $size = array(700, 700);
  }

  if (has_post_thumbnail($post_id)) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size );
    return $image[0];
  } else {
    return '';
  }
}


// Get post attachements
function get_post_attachments($post_id) {
  $args = array(
         'post_type' => 'attachment',
         'numberposts' => -1,
         'post_status' => 'inherit',
         'post_type' => 'attachment',
         'post_parent' => $post_id,
         'orderby' => 'menu_order',
         'order' => 'ASC'
  );
  $attachments = get_posts($args);
  return $attachments;
}



// General functions

// Create a thumb class for article
function thumb_class($index) {
  return "thumb c" . $index;
}


// Get title for any page, post or archive
function get_title() {
  if (function_exists('is_tag') && is_tag()) { 
    return 'Arhiva etichete &quot;' . $tag . '&quot;'; 
  } elseif (is_archive()) { 
    return wp_title('', false); 
  } elseif (is_search()) { 
    return 'Rezultatul cautarii pentru &quot;' . wp_specialchars($s) . '&quot;'; 
  } elseif (!(is_404()) && (is_single()) || (is_page())) { 
    return wp_title('', false); 
  } elseif (is_404()) { 
    return 'Pagina inexistenta'; 
  } elseif (is_home()) {
    return bloginfo('description');
  }
}




/* Set up Wordpress
  - swicth on/off features by special functions
*/


/* Add excerpt to Pages */
add_action('init', 'add_excerpt_to_pages');
function add_excerpt_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
        

/* Show the default image widget in the post editor */
add_theme_support( 'post-thumbnails' ); 


/* The main menu is now manageable via the Wordpress Admin Panel */
register_nav_menus();





/* Helpers
  - PHP functions used in the code
*/


/* Transform a string into a class name
  - Example: 'New York' -> 'new-york'
*/
function string_to_classname($string) {
  $ret = '';
  
  if ($string) {
    $ret = str_replace(' ', '-', strtolower($string));
  }
  return $ret;
}


?>
