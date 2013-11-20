<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	  
	  <title><?php wp_title( '|', true, 'right' ); ?></title>
	  
	  <link rel="profile" href="http://gmpg.org/xfn/11">
	  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	  
	  <!-- Enable HTML5 compatibility with old browsers -->
    <!--[if lt IE 9]>
    	<script src="<?php echo get_template_directory_uri(); ?>/assets/html5shiv.js"></script>
    <![endif]-->
    
    <!-- Enable responsiveness on old browsers -->
    <!--[if (lt IE 9) & (!IEMobile)]>
    	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
	  
	  <!-- The stylesheet via Compass and SASS -->
	  <link href="<?php echo get_template_directory_uri(); ?>/assets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_template_directory_uri(); ?>/assets/print.css" media="print" rel="stylesheet" type="text/css" />
    
    <!--[if lt IE 9]>
        <link href="<?php echo get_template_directory_uri(); ?>/assets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->
    
    <!-- Responsive images -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/matchmedia.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/picturefill.js"></script>
    
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    
	  <link rel="author" href="humans.txt" />
	  <?php wp_head(); ?>
  </head>
  
  <body <?php body_class(); ?>>
    <div class="container">
    
    <header id="header" role="banner">
      <?php include '_logo.php'; ?>
      
      <figure>
        <?php 
          $img = get_template_directory_uri() . "/assets/jeep.jpg";
          $title = esc_attr(get_bloginfo('name','display')); 
          $retina = false;
          include '_responsive-images.php';
        ?>
        <figcaption>
          <?php echo $title; ?>
        </figcaption>
      </figure>
      
      
      <?php include '_navigation.php'; ?>
    </header>
    
    <main id="main">
    
      
