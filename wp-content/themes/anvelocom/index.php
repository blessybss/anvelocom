<?php 
  /* The Wordpress loop
    - displays everything (archives, single posts, single pages) unless the front page and the special product pages
  */
?>

<?php get_header(); ?>

<?php include '_intro.php' ?>

<?php   
  // Single product page
  if (is_single()) {
    $image_size = 'full';
    $klass = 'product';
  }
  
  // If single page or archives page
  $section_klass = 'articles';
  if (is_single() || is_page()) {
    $section_klass = '';
  }
  
  // Special product category pages
  if (is_page($SPECIAL_PAGES)) {
    include '_product_category_page.php';
  } else {
?>

  <section id="index" class="<?php echo $section_klass ?>">
    <h2>Index</h2>
    <?php 
      if (have_posts()) {
        $index = 0;
        while ( have_posts() ) : the_post(); 
          $article = $post; 
          $post_id = $article->ID;
          
          if (!isset($image_size)) { 
            $image_size = 'medium';
          }
          if (!isset($klass)) { 
            $klass = thumb_class($index);
          }
          
          include '_article.php';
          $index++;
          
          // Content pages
          if (is_page()) {
            comments_template();
          }
        endwhile;
		  } else {
		    include '_not-found.php';
		  }
	  ?>
  </section>
  
  <?php if (is_single()) { 
    // Get product's main category
    $main_category = get_post_main_category_slug($post);
    
    // Get product dimensions from meta fields / filters
    $dimension = get_product_dimension($post, $main_category);
    
    // Get similar posts
    $articles = get_similar_posts($post, $main_category, $dimension);
    $title = 'Alte variante pt. ' . $dimension;
    $link = '';
    $id = 'variations';
    include '_articles.php';
    
    // Get brands for this category
    $parent_slug = $main_category; 
    include '_brands.php';
  } ?>


  <?php if (is_page()) { ?>
    <nav id="sidebar">
      <h3>Toate categoriile de produse</h3>
      <ul>
        <?php wp_list_categories(array(
          'title_li' => '',
          'exclude' => $CATEGORY_META,
        )); ?>  
      </ul>
    </nav>
  <?php } ?>

<?php } ?>

<?php get_footer(); ?>
