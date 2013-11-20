<?php get_header(); ?>

  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        
        
      <?php endwhile;
		} else { ?>
		  
		  <section id="not-found">
          <div class="container">
            <article>
              <div class="inner">
                <h1>Not found</h1>
              </div>
            </article>
          </div>
        </section>
		  
		<?php }
	?>

<?php get_footer(); ?>
