<?php
  /* Displays a list of articles
    - all articles will have the class="thumb cXXX"
    - articles for filtering with isotope will have extra class attributes
    - the $filters  will tell if to create the special classes for isotope filtering
  */
?>

<?php if ($articles) { ?>

  <section id="<?php echo $id ?>" class="articles">
    <h2>
      <?php
        echo ($link) ? "<a href='" . $link . "'>" . $title . "</a>" : $title;
      ?>
    </h2>
    <?php 
      foreach ($articles as $index => $article) { 
        $klass = thumb_class($index + 1);
        
        if (isset($filters) && (!empty($filters))) {
          $klass2 = get_article_class($filters, $article);
          $klass .= ' ' . implode(' ', $klass2);
        }
        
        include '_article.php';
      }
    ?>
  </section>

<?php } ?>

