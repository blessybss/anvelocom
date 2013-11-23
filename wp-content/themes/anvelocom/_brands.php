<h1>Toate marcile</h1>
<?php
  $brands = get_anvelope_brands();
  if ($brands) { ?>
    <?php foreach ($brands as $index=>$article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <figure>
          <?php
            if (function_exists('z_taxonomy_image_url')) {
              //$img = z_taxonomy_image_url($article->term_id);
              $img = 'http://placehold.it/250x150';
              $title = $article->name;
              $link = get_category_link($article->term_id);
              $retina = false;
              include '_responsive-images.php';
            }
          ?>
          <figcaption>
            <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a>
          </figcaption>
        </figure>
      </article>
    <?php }
  }
?>