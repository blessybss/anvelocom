<?php


// Constants
$PAGE_ANVELOPE = 'categoryanvelope-auto-offroad';
$PAGE_JENTI = 'jante-auto-aluminiu-si-tabla';
$PAGE_TUNING = 'tuning-auto-powertuning';
$CATEGORY_META = '467';



// Get posts, categories, and so on


/* Get anvelope brands */
function get_anvelope_brands() {
  $c = get_category_by_slug('anvelope-auto-offroad');
  $category_id = $c->term_id;
  
  return get_categories(array(
    'child_of' => $category_id,
  ));
}


/* Get the latest anvelopes */
function get_anvelopes($how_many) {
  $c = get_category_by_slug('anvelope-auto-offroad');
  $category_id = $c->term_id;
  
  $p = get_cat_ID('Produs');
  return get_posts(array(
    'category__and' => array($category_id, $p),
    'posts_per_page' => $how_many,
  ));
}


/* Get the content of About Us */
function get_date_firma() {
  $about_us = get_page_by_title( 'Date firma' ); 
  $page_data = get_page($about_us);
  return $page_data->post_content;
}








// Filter anvelopes

function get_dimensions($posts) {
  $ret = array();
  if ($posts) {
    foreach ($posts as $post) {
      $ret = array_merge($ret, get_dimension($post));
    }
  }
  return array_filter(array_unique($ret));
}

function get_latimes($posts) {
  $ret = array();
  if ($posts) {
    foreach ($posts as $post) {
      $ret = array_merge($ret, get_latime($post));
    }
  }
  return array_filter(array_unique($ret));
}

function get_inaltimes($posts) {
  $ret = array();
  if ($posts) {
    foreach ($posts as $post) {
      $ret = array_merge($ret, get_inaltime($post));
    }
  }
  return array_filter(array_unique($ret));
}

function get_brands($posts) {
  $ret = array();
  if ($posts) {
    foreach ($posts as $post) {
      $ret = array_merge($ret, get_brand($post));
    }
  }
  return array_filter(array_unique($ret));
}

function get_profs($posts) {
  $ret = array();
  if ($posts) {
    foreach ($posts as $post) {
      $ret = array_merge($ret, get_prof($post));
    }
  }
  return array_filter(array_unique($ret));
}


function get_dimension($post) {
  $ret = array();
  if ($post) {
    $ret = get_post_meta($post->ID, 'Dimensiune janta');
  }
  return $ret;
}

function get_latime($post) {
  $ret = array();
  if ($post) {
    $ret = get_post_meta($post->ID, 'latime');
  }
  return $ret;
}

function get_inaltime($post) {
  $ret = array();
  if ($post) {
    $ret = get_post_meta($post->ID, 'inaltime');
  }
  return $ret;
}

function get_brand($post) {
  $ret = array();
  if ($post) {
    //$ret = get_post_meta($post->ID, 'brandi');
  }
  return $ret;
}

function get_prof($post) {
  $ret = array();
  if ($post) {
    $ret = get_post_meta($post->ID, 'profil');
  }
  return $ret;
}


function get_article_class($post) {
  $klass = array();
  $klass = array_merge($klass, get_dimension($post));
  $klass = array_merge($klass, get_inaltime($post));
  $klass = array_merge($klass, get_latime($post));
  $klass = array_merge($klass, get_brand($post));
  $klass = array_merge($klass, get_prof($post));
  $klass = array_map("string_to_classname", $klass);
  return $klass;
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
