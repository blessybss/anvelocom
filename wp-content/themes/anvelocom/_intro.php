<?php 
  /* Displaying an image below the header
    - only the frontpage image is different, the rest of pages have the same image
  */
?>

<section id="intro">
  <h2>Intro</h2>
  <figure>
    <?php 
      if (!isset($img)) {
        $img = get_template_directory_uri() . "/assets/jeep-for-title.jpg";
      }
      if (!isset($title)) {
        $title = get_title(); 
      }
      $retina = false;
      include '_responsive-images.php';
    ?>
    <figcaption>
      <a href="<?php echo $link;?>"><?php echo $title;?></a>
    </figcaption>
  </figure>
</section>
