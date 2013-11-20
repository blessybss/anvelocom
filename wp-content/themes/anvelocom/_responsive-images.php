<?php 
  /*
    Responsive Images
    - displaying images optimized for retina, desktop, mobile
    - the entire application is using this single function to display any image
    
    Input parameters:
    - $img, which is an url to the original image, the largest size possible
    - $title, the title of the image
    - $link, where the image points
    - $retina, if the image is already retina ready
  */
?>


<?php if ($img) { ?>
  
  <?php if (empty($title)) { $title = ''; } ?>
  <?php if (empty($retina)) { $retina = false; } ?>
  <?php if (empty($link)) { $link = false; } ?>
  
  <?php if ($link) { ?>
    <a href="<?php echo $link ?>" title="<?php echo $title ?>">
  <?php } ?>
  
  <?php 
    if ($retina) {
      /* If the image is retina ready we can halve for normal desktops */
      list($width, $height) = getimagesize($img);
      $img_normal = wpthumb($img, 'width=' . $width/2 . '&height=' . $height/2 .'&crop=1&crop_from_position=center,center');
      $img_retina = $img;
    
    } else {
      /* If the image is not retina ready we are not dealing with it, for now */
      $img_normal = $img;
      $img_retina = $img;
    }
  ?>
  
  <div data-picture data-alt="<?php echo $title ?>">
    <!-- desktop -->
    <div data-src="<?php echo $img_normal?>"></div>
    <div data-src="<?php echo $img_retina ?>" data-media="(min-width: 768px) and (min-device-pixel-ratio: 2.0)"></div>
    
    <!-- mobile -->
    <div data-src="<?php echo wpthumb($img_normal, 'width=640&height=960&crop=1&crop_from_position=center,center'); ?>" data-media="(max-width: 767px)"></div>
    <div data-src="<?php echo wpthumb($img_retina, 'width=900&height=1600&crop=1&crop_from_position=center,center'); ?>" data-media="(max-width: 767px) and (min-device-pixel-ratio: 2.0)"></div>
    
    <!-- In IE8 the Slider cannot set the background image. This is a workaround -->
    <!--[if (lt IE 9) & (!IEMobile)]>
      <span data-src="<?php echo $img_normal?>"></span>
    <![endif]-->
    
    <noscript>
      <img src="<?php echo $img_normal ?>" alt="<?php echo $title ?>">
    </noscript>
  </div>
  
  <?php if ($link) { ?>
    </a>
  <?php } ?>

<?php } ?>
