<?php get_header(); ?>

<?php include '_intro.php' ?>

<section id="content">
  <h2>Content</h2>
  <article class="page">
    <?php  
      if (have_posts()) {
        while ( have_posts() ) : the_post(); 
          $post_id = $post->ID; ?> 
          <div id="body">
            <?php the_content(); ?>
          </div>
          
          <?php comments_template();
        endwhile;
	    } else {
	      include '_not-found.php';
	    }
    ?>
  </article>


  <nav id="sidebar">
    <h3>Toate categoriile de produse</h3>
    <ul>
      <?php wp_list_categories(array(
        'title_li' => '',
        'exclude' => '467',
      )); ?>  
    </ul>
  </nav>
</section>

<?php get_footer(); ?>


