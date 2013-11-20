<?php get_header(); ?>

<section>
  <?php 
    if (have_posts()) {
      $index = 0;
      while ( have_posts() ) : the_post(); ?>
        <?php $article = $post; ?>
        <article class="thumb c<?php echo $index + 1 ?>">
          <?php 
            $image_size = 'medium';
            include '_article.php';
          ?>
       </article>
       <?php $index++; ?>
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>
</section>

<?php get_footer(); ?>
