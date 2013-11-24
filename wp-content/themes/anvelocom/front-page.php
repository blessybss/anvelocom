<?php get_header(); ?>

<section id="intro">
  <h2>Intro</h2>
  <figure>
    <?php 
      $img = get_template_directory_uri() . "/assets/jeep-smaller.jpg";
      $title = esc_attr(get_bloginfo('name','display')); 
      $retina = false;
      include '_responsive-images.php';
    ?>
    <figcaption>
      <a href=""><?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?></a>
    </figcaption>
  </figure>
</section>


<section id="anvelope">
  <h2><a href="">Produse noi</a></h2>
  <?php 
    $anvelopes = get_anvelopes(5);  
    if ($anvelopes) { ?>
      <?php foreach ($anvelopes as $index=>$article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <?php 
          $image_size = 'medium';
          include '_article.php';
        ?>
     </article>
    <?php } ?>
  <?php } ?>
</section>

<section id="reduceri">
  <h2><a href="">Reduceri</a></h2>
  <?php 
    $anvelopes = get_anvelopes(5);  
    if ($anvelopes) { ?>
      <?php foreach ($anvelopes as $index=>$article) { ?>
      <article class="thumb c<?php echo $index + 1 ?>">
        <?php 
          $image_size = 'medium';
          include '_article.php';
        ?>
     </article>
    <?php } ?>
  <?php } ?>
</section>


<section id="bestsellers">
  <h2><a href="">Cele mai vandute</a></h2>
  <?php 
    $anvelopes = get_anvelopes(5);  
    if ($anvelopes) { ?>
      <?php foreach ($anvelopes as $index=>$article) { ?>
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
