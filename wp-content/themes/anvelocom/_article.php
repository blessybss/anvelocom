<?php
  /* Displays a single article, or a category with image (Brands)
  */
?>

<article class="<?php echo $klass ?>">
  <?php if ($article) { 
    $image_size = 'medium';
        
    if (isset($type) && ($type == 'category')) {
      $img = z_taxonomy_image_url($article->term_id);
      $title = $article->cat_name;
      $link = get_category_link($article->term_id);
      $price = array();
      $dimension = '';
    } else {
      $img = get_post_featured_image_url($article->ID, $image_size);
      $title = $article->post_title;
      $link = get_permalink($article->ID);
      $price = get_price($article->ID);
      
      $main_category = get_post_main_category_slug($article);
      $dimension = get_product_dimension($article, $main_category);
    }
    
    // $img = 'http://placehold.it/350x250'; 
    ?>
    
    <header>
      <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
    </header>
    
    <figure>
      <?php
        $retina = false;
        include '_responsive-images.php';
      ?>
      <figcaption>
        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a>
      </figcaption>
    </figure>
    
    <aside>
      <h4>Details</h4>
      <ul id="price">
        <?php if ($price) {
          foreach ($price as $pr) { ?>
            <li><?php echo $pr ?> RON</li>
          <?php }
        } else { ?>
          <li>100 RON</li>
        <?php } ?>
      </ul>
      
      <div id="dimension">
        <span><?php echo $dimension ?></span>
      </div>
      
      <div id="content">
        <?php echo $article->post_content ?>
      </div>
    </aside>
  <?php } ?>
</article>
