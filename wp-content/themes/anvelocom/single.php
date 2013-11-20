<?php get_header(); ?>

  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        
        single
        
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>

<?php get_footer(); ?>
