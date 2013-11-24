

<?php if ($article) { ?>
  <header>
    <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
  </header>
  
  <figure>
    <?php
      $img = get_post_featured_image_url($article->ID, $image_size);
      
      $img = 'http://placehold.it/350x250';
      
      $title = $article->post_title;
      $link = get_permalink($article->ID);
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
  </aside>
<?php } ?>
