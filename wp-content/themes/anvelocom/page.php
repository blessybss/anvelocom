<?php get_header(); ?>

<?php include '_intro.php' ?>

<section id="page">
  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        
        <div id="content">
          <?php the_content() ?>
        </div>
        <?php comments_template(); ?> 
        
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>
</section>

<nav id="sidebar">
  <h3>Produse</h3>
  <ul>
    <?php wp_list_categories(array(
      'title_li' => '',
      'exclude' => '467',
    )); ?>  
  </ul>
</nav>

<?php get_footer(); ?>


<!--
<?php
	        $mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'post_date', 'sort_order' => 'desc' ) );

	        foreach( $mypages as $page ) {		
		        $content = $page->post_content;
		        if ( ! $content ) // Check for empty page
			        continue;

		        $content = apply_filters( 'the_content', $content );
	        ?>
		        <h2><a href="<?php echo get_page_link( $page->ID ); ?>"><?php echo $page->post_title; ?></a></h2>
		        <div class="entry"><?php echo $content; ?></div>
	        <?php
	        }	
        ?>
-->
