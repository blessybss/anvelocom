<?php
  $brands = get_anvelope_brands();
  if ($brands) { ?>
    <article class="thumb c0">
      <h1><a href="">Toate marcile</a></h1>
    </article>
    <?php foreach ($brands as $index=>$article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <figure>
          <?php
            if (function_exists('z_taxonomy_image_url')) {
              //$img = z_taxonomy_image_url($article->term_id);
              $img = 'http://placehold.it/250x150';
              $title = $article->name;
              $link = $article->slug;
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
