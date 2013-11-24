<section id="brands">
  <h2>Toate marcile</h2>
<?php
  $brands = get_anvelope_brands();
  if ($brands) { ?>
    <?php foreach ($brands as $index => $article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <?php 
          //$img = z_taxonomy_image_url($article->term_id);
          $image_size = 'medium';
          include '_article.php';
        ?>
     </article>
    <?php }
  }
?>
</section>

