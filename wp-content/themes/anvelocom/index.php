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
  
  // Special pages
  if (is_page(array($PAGE_ANVELOPE, $PAGE_JENTI, $PAGE_TUNING))) {
    include '_product_category_page.php';
  } else {
?>

  <section>
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


  <?php if (is_single()) { ?>
    <section id="variations">
      <nav>
        <h2>Alte variante pt. 205/R16/60</h2>
        <h2><a href="">&larr; Inapoi la configurator</a></h2>
      </nav>
      <?php
        $related_posts = MRP_get_related_posts($post_id, true);
        if ($related_posts) { ?>
          <?php foreach ($related_posts as $index=>$article) { ?>
          <article class="thumb c<?php echo $index + 1 ?>">
            <?php 
              $image_size = 'medium';
              include '_article.php';
            ?>
         </article>
        <?php }
        }
      ?>
    </section>
    
    <?php include '_brands.php' ?>
  <?php } ?>


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
