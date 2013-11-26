<?php
  /* Displays a list of articles
    - all articles will have the class="thumb cXXX"
    - articles for filtering with isotope will have extra class attributes
    - the $filters boolean will tell if to create the special classes for isotope filtering
  */
?>

<?php if ($articles) { ?>

  <section id="<?php echo $id ?>" class="articles">
    <h2><a href="<?php echo $link ?>"><?php echo $title ?></a></h2>
    <?php 
      foreach ($articles as $index => $article) { 
        $klass = thumb_class($index + 1);
        
        if ($filters) {
          $klass2 = get_article_class($FILTERS_ANVELOPE, $article);
          $klass .= ' ' . implode(' ', $klass2);
        }
        
        include '_article.php';
      }
    ?>
  </section>

<?php } ?>

