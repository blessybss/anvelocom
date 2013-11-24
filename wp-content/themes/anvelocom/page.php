<?php get_header(); ?>

<?php include '_intro.php' ?>

<article class="page">
  <?php  
    if (have_posts()) {
      while ( have_posts() ) : the_post(); 
        $post_id = $post->ID; 
        $article = $post;
        $image_size = 'full';
        include '_article.php';
        
        comments_template();
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

<?php get_footer(); ?>


