<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->


  <!-- jQuery from CDN and local fallback -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery-1.10.2.min.js">\x3C/script>')</script>
  
  <!-- jQuery Isotope plugin -->
  <script src="<?php echo get_template_directory_uri(); ?>/jquery.isotope.min.js"></script>

  <!-- Site specific scripts built on jQuery -->
  <script src="<?php echo get_template_directory_uri(); ?>/jquery.anvelocom.js"></script>


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">
	
	  <div id="by-cs">
	    <div id="filters">
	      <?php
	        $filters = get_posts(array(
            'posts_per_page' => 10,
          ));
          
          $d = get_dimensions($filters);
          $i = get_inaltimes($filters);
          $l = get_latimes($filters);
          
	      ?>
	      
	      <select class="option-set" data-filter-group="latime">
				  <option selected data-filter-value="xxxx">Selectati Latime ...</option>
				  <?php foreach ($l as $p) { ?>
					  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
				  <?php } ?><option data-filter-value="">Toate latimile</option>
			  </select>
			
			  <select class="option-set" data-filter-group="inaltime">
				  <option selected data-filter-value="zzzz">Selectati Inaltime (talon) ...</option>
				  <?php foreach ($i as $p) { ?>
					  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
				  <?php } ?>
				  <option data-filter-value="">Toate inaltimile</option>
			  </select>

			
			  <select class="option-set" data-filter-group="diameter">
				  <option selected data-filter-value="yyyy">Selectati Dimensiune janta ...</option>
				  <?php foreach ($d as $p) { ?>
					  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
				  <?php } ?>
				  <option data-filter-value="">Toate dimensiunile</option>
			  </select>
	    </div>
	
	    <div id="posts">
	      <?php foreach ($filters as $article) { ?>
	        <?php $klass = get_article_class($article); ?>
          <article class="<?php echo implode(' ', $klass); ?> thumb">
	          <?php
              $img = get_post_featured_image_url($article->ID, 'medium');
              $title = $article->post_title;
              $link = get_permalink($article->ID);
            ?>
            
            <figure>
              <a href="<?php echo $link ?>" title="<?php echo $title ?>">
                <img src="<?php echo $img ?>" title="<?php echo $title ?>">
              </a>
            </figure>
            
            <div>
              <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
            </div>
	        </article>
	      <?php } ?>
	  </div>
	  </div>
	  
