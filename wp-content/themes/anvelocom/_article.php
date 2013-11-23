

<?php if ($article) { ?>
  <figure>
    <?php
      $img = get_post_featured_image_url($article->ID, $image_size);
      
      //$img = 'http://placehold.it/350x250';
      
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
    <div id="title">
      <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
    </div>
    
    <div id="details">
      <div id="price">
        <ul>
          <li>390 RON</li>
          <li>490 RON</li>
        </ul>
      </div>
    </div>
  </aside>
<?php } ?>
