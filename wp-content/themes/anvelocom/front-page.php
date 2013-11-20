<?php get_header(); ?>

<section id="intro">
  <figure>
    <?php 
      $img = get_template_directory_uri() . "/assets/jeep.jpg";
      $title = esc_attr(get_bloginfo('name','display')); 
      $retina = false;
      include '_responsive-images.php';
    ?>
    <figcaption>
      <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>
    </figcaption>
  </figure>
</section>

<section id="anvelope">
  <h2>Anvelope noi</h2>
  <?php 
    $anvelopes = get_anvelopes(10);  
    if ($anvelopes) {
      foreach ($anvelopes as $index=>$article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <?php 
          $image_size = 'medium';
          include '_article.php';
        ?>
     </article>
    <?php } ?>
  <?php } ?>
</section>

<?php get_footer(); ?>
