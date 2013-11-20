</main>

<footer id="footer">
  <?php include '_logo.php'; ?>
  <?php include '_navigation.php'; ?>
  
  <aside>
    <?php echo get_date_firma(); ?>
  </aside>
</footer>



<!-- jQuery from CDN and local fallback -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery-1.10.2.min.js">\x3C/script>')</script>

<!-- jQuery Isotope plugin -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery.isotope.min.js"></script>

<!-- Site specific scripts built on jQuery -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery.reboot.js"></script>
 
 
   
</div> <!-- container -->
</body>
</html>
