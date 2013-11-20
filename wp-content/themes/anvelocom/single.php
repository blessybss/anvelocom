<?php get_header(); ?>

<section>
  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        <article>
          <h1>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
          </h1>
          
          <figure>
            <?php
              $img = get_post_featured_image_url($post->ID, 'full');
              $title = $post->post_title;
              $link = get_permalink($post->ID);
              $retina = false;
              include '_responsive-images.php';
            ?>
            <figcaption>
              <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </figcaption>
          </figure>
          
          <aside>
            <?php the_content(); ?>
          </aside>
        </article>
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>
</section>
<?php get_footer(); ?>
