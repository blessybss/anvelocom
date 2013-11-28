<?php 
  echo 'slug: ' . $parent_slug;
  $articles = get_children_categories($parent_slug);
  $title = 'Toate marcile';
  $link = '';
  $id = 'brands';
  $filters = false;
  $type = 'category';
  include '_articles.php';
?>


