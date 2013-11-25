<?php
  /* Displays a list of articles
  */
?>

<section id="<?php echo $id ?>" class="articles">
  <h2><a href="<?php echo $link ?>"><?php echo $title ?></a></h2>
  <?php 
    if ($articles) { 
      foreach ($articles as $index => $article) { 
        $klass = thumb_class($index + 1);
        include '_article.php';
      }
    } 
  ?>
</section>

