<section id="intro">
  <figure>
    <?php 
      $img = get_template_directory_uri() . "/assets/jeep-for-title.jpg";
      $title = get_the_title(); 
      $link = get_permalink();
      $retina = false;
      include '_responsive-images.php';
    ?>
    <figcaption>
      <a href="<?php echo $link;?>"><?php echo $title;?></a>
    </figcaption>
  </figure>
</section>
