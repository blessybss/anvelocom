<?php get_header(); ?>

<?php 
  $img = get_template_directory_uri() . "/assets/jeep-smaller.jpg";
  $title = esc_attr(get_bloginfo('description','display')); 
  $retina = false;
  include '_intro.php';
?>


<?php 
  $articles = get_posts_from_category(CATEGORY_PRODUS, 4);
  $title = 'Produse noi';
  $link = get_category_url(CATEGORY_PRODUS);
  $id = 'anvelope';
  $first_article = true;
  include '_articles.php';
?>


<?php 
  $articles = get_posts_from_category(CATEGORY_REDUCERI, 4);
  $title = 'Reduceri';
  $link = get_category_url(CATEGORY_REDUCERI);
  $id = 'reduceri'; 
  include '_articles.php';
?>

<?php 
  $articles = get_posts_from_category(CATEGORY_BESTSELLERS, 4);
  $title = 'Cele mai vandute';
  $link = get_category_url(CATEGORY_BESTSELLERS);
  $id = 'bestsellers'; 
  include '_articles.php';
?>

<?php get_footer(); ?>
