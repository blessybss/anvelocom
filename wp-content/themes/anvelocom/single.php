<?php get_header(); ?>

<?php include '_intro.php' ?>

<section id="article">
  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); 
        $post_id = $post->ID; ?>
        <article>
          <h1>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
          </h1>
          
          <div id="content">
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
          </div>
        </article>
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>
</section>

<section id="variations">
  <?php
    $related_posts = MRP_get_related_posts($post_id, true);
    if ($related_posts) { ?>
      <article class="thumb c0">
        <h1><a href="">Variatii</a></h1>
      </article>
      
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

<section id="brands">
  <?php include '_brands.php' ?>
</section>



<?php get_footer(); ?>
