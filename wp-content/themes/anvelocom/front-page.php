<?php get_header(); ?>

<?php 
  $img = get_template_directory_uri() . "/assets/jeep-smaller.jpg";
  $title = esc_attr(get_bloginfo('description','display')); 
  $retina = false;
  include '_intro.php';
?>


<?php 
  $articles = get_anvelopes(5);
  $title = 'Produse noi';
  $link = '';
  $id = 'anvelope';
  include '_articles.php';
?>


<?php 
  $articles = get_anvelopes(5);
  $title = 'Reduceri';
  $link = '';
  $id = 'reduceri'; 
  include '_articles.php';
?>

<?php 
  $articles = get_anvelopes(5);
  $title = 'Cele mai vandute';
  $link = '';
  $id = 'bestsellers'; 
  include '_articles.php';
?>

<?php get_footer(); ?>
