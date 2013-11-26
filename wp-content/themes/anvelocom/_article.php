<?php
  /* Displays a single article, or a category with image (Brands)
  */
?>

<article class="<?php echo $klass ?>">
  <?php if ($article) { ?>
    <header>
      <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
    </header>
    
    <figure>
      <?php
        $image_size = 'medium';
        
        if (isset($type) && ($type == 'category')) {
          $img = z_taxonomy_image_url($article->term_id);
          $title = $article->cat_name;
          $link = get_category_link($article->term_id);
        } else {
          $img = get_post_featured_image_url($article->ID, $image_size);
          $title = $article->post_title;
          $link = get_permalink($article->ID);
        }
        
        $img = 'http://placehold.it/350x250';
        
        $retina = false;
        include '_responsive-images.php';
      ?>
      <figcaption>
        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a>
      </figcaption>
    </figure>
    
    <aside>
      <h4>Details</h4>
      <ul>
        <li>390 RON</li>
        <li>490 RON</li>
      </ul>
      
      <div id="content">
        <?php echo $article->post_content ?>
      </div>
    </aside>
  <?php } ?>
</article>
