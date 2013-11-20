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
      <a href=""><?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?></a>
    </figcaption>
  </figure>
</section>

<section id="anvelope">
  <?php 
    $anvelopes = get_anvelopes(4);  
    if ($anvelopes) { ?>
      <article class="thumb c0">
        <h1><a href="">Produse noi</a></h1>
      </article>
      
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
  <?php 
    $anvelopes = get_anvelopes(4);  
    if ($anvelopes) { ?>
      <article class="thumb c0">
        <h1><a href="">Reduceri</a></h1>
      </article>
      
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
  <?php 
    $anvelopes = get_anvelopes(4);  
    if ($anvelopes) { ?>
      <article class="thumb c0">
        <h1><a href="">Cele mai vandute</a></h1>
      </article>
      
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
