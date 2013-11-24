<?php get_header(); ?>

<?php include '_intro.php' ?>

<article class="product">
  <?php  
    if (have_posts()) {
      while ( have_posts() ) : the_post(); 
        $post_id = $post->ID; 
        $article = $post;
        $image_size = 'full';
        include '_article.php';
      endwhile;
	  } else {
	    include '_not-found.php';
	  }
  ?>
</article>

<section id="variations">
  <h2>Alte variante la dimensiunea 205/R16/60</h2>  
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
  
  <article class="thumb title">
    <h3><a href="">&larr; Inapoi la configurator</a></h3>
  </article>
</section>


<?php include '_brands.php' ?>



<?php get_footer(); ?>
