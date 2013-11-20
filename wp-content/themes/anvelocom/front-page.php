<?php get_header(); ?>

<section id="anvelope">
  <h2>Anvelope noi</h2>
  <?php 
    $anvelopes = get_anvelopes(15);  
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
