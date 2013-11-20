<?php


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
function get_about_us() {
  $about_us = get_page_by_title( 'About Us' ); 
  $page_data = get_page($about_us);
  return $page_data->post_content;
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
