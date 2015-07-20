<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	  <!-- http://perishablepress.com/how-to-generate-perfect-wordpress-title-tags-without-a-plugin/ -->
	  <title><?php echo get_title() ?> - <?php echo bloginfo('name'); ?></title>

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
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

	  <link rel="author" href="humans.txt" />


    <!-- Google Analytics -->
    <?php include_once("ga.php") ?>


	  <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div class="container">

    <header id="header" role="banner">
      <h1 itemscope itemtype="http://schema.org/Organization">
        <a itemprop="url" class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
          <?php bloginfo('name'); ?>
        </a>
        <img itemprop="logo" src="<?php echo get_template_directory_uri(); ?>/assets/anvelocom-logo.png" title="Anvelocom logo">
      </h1>

      <?php include '_navigation.php'; ?>

      <nav id="contact">
        <h3>Contact</h3>
        <ul>
          <li>Tel: 0744-374-914</li>
          <li>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>/cos-cumparaturi/" title="Cos cumparaturi">
              Cos (<?php echo get_myeshop_cart_itemcount() ?>)
            </a>
          </li>
        </ul>
      </nav>
    </header>

    <main id="main">
