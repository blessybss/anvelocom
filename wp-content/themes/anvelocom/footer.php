</main>

<footer id="footer">

    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Anvelocom",
      "description": "<?php bloginfo('description'); ?>",
      "telephone": "+40-744-374-914",
      "email": "vanzari@anvelocom.ro",
      "logo": "<?php echo get_template_directory_uri(); ?>/assets/anvelocom-logo.png",
      "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Brasov, Romania",
        "postalCode": "500398",
        "streetAddress": "Bd. Alexandru Vlahuta, Nr. 59"
      }
    }
    </script>


  <div id="company">
    <h1>
      <aclass="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <?php bloginfo('name'); ?>
      </a>
    </h1>
    <p>
      <?php bloginfo('description'); ?>
    </p>
    <address>
      <?php echo get_date_firma(); ?>

      <p>
        © 2013 Anvelocom. Toate drepturile rezervate. <a href="http://www.anpc.gov.ro/" title="Protectia consumatorilor">Protectia consumatorilor</a>.
      </p>
    </address>
  </div>

  <nav>
    <h3>Go top</h3>
  </nav>
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
