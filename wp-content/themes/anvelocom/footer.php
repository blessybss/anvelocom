</main>

<footer id="footer">
  <div id="company">
    <h1>
      <a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <?php bloginfo('name'); ?>
      </a>
    </h1>
    <p>
      <?php bloginfo('description'); ?>
    </p>
    <address>
      <?php echo get_date_firma(); ?>
    </address>
  </div>
  
  <span></span>
</footer>



<!-- jQuery from CDN and local fallback -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery-1.10.2.min.js">\x3C/script>')</script>

<!-- jQuery Isotope plugin -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery.isotope.min.js"></script>

<!-- Site specific scripts built on jQuery -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/jquery.anvelocom.js"></script>
 
 
   
</div> <!-- container -->
</body>
</html>
