<?php get_header(); ?>

<?php include '_intro.php' ?>

<section id="page">
  <?php 
    if (have_posts()) {
      while ( have_posts() ) : the_post(); ?>
        
        page
        
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
        
      <?php endwhile;
		} else {
		  include '_not-found.php';
		}
	?>
</section>

<section id="sidebar">
  <?php wp_list_categories(array(
    'title_li' => '',
    'exclude' => '467',
  )); ?>  
</section>

<?php get_footer(); ?>
