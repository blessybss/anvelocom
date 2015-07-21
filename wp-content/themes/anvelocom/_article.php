<?php
  /* Displays a single article, or a category with image (Brands)
  */
?>

<article class="<?php echo $klass ?>">
  <?php if ($article) {
    $image_size = 'medium';

    if (isset($type) && ($type == 'category')) {
      $img = z_taxonomy_image_url($article->term_id);
      $title = $article->cat_name;
      $link = get_category_link($article->term_id);
      $price = array();
      $dimension = '';
    } else {
      $img = get_post_featured_image_url($article->ID, $image_size);
      $title = $article->post_title;
      $link = get_permalink($article->ID);

      $product = get_eshop_product($article->ID);
      $price = get_price($product);
      $stock = get_stock($product);

      $main_category = get_post_main_category_slug($article);
      $dimension = get_product_dimension($article, $main_category);

      ?>
      <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Product",
        "name": "<?php echo $title ?>",
        "description": "<?php echo $article->post_excerpt; ?>",
        "image": "<?php echo $img ?>",
        "productID": "<?php echo $article->ID ?>",
        "sku": "<?php echo $article->ID ?>",
        "offers": {
          "@type": "Offer",
          "availability": "http://schema.org/InStock",
          "price": "<?php echo $price[0] ?>",
          "priceCurrency": "RON",
          "itemCondition": "http://schema.org/NewCondition"
        },
        "brand": {
          "@type": "Organization",
          "name": "<?php echo get_product_brand($article->ID); ?>"
        },
        "manufacturer": {
          "@type": "Organization",
          "name": "<?php echo get_product_brand($article->ID); ?>"
        },
        "model": "<?php echo get_product_model($article->ID); ?>"
      }
      </script>
      <?php
    }
    ?>

    <header>
      <h3><a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a></h3>
    </header>

    <figure>
      <?php
        $retina = false;
        include '_responsive-images.php';
      ?>
      <figcaption>
        <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a>
      </figcaption>
    </figure>

    <aside>
      <h4>Details</h4>
      <ul id="price">
        <?php if ($price) {
          foreach ($price as $pr) { ?>
            <li><?php echo $pr ?> RON</li>
          <?php }
        } ?>
      </ul>

      <div id="dimension">
        <span><?php echo $dimension ?></span>
      </div>

      <?php if ($klass == 'product') { ?>
        <div id="stock">
          <span class="stock__label">Stoc:</span>
          <span class="stock__value"><?php echo $stock ?></span>
          <?php if ($stock < 1) { ?>
            <span class="stock--empty">
              <a href="mailto:vanzari@anvelocom.ro?subject:Notificare stoc?body:Produs: <?php echo $link ?>" title="Notificare prin email">Doresc sa fiu notificat prin e-mail cand acest produs va fi din nou pe stoc.</a>
            </span>
          <?php } else { ?>
            <div id="add-to-cart">
              <?php echo do_shortcode('[eshop_addtocart]'); ?>
            </div>
          <?php } ?>
        </div>
      <?php } ?>

      <div id="content">
        <?php
          $content = get_the_content();
          $content = apply_filters('the_content', $content);
          $content = str_replace(']]>', ']]&gt;', $content);
          print $content;
        ?>
      </div>
    </aside>
  <?php } ?>
</article>
