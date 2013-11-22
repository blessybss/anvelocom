<?php get_header(); ?>

<?php include '_intro.php' ?>

  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        
        jenti
        
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>

<?php get_footer(); ?>
