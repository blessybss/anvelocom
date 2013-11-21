<?php get_header(); ?>

<section id="brands">
  <?php
    $brands = get_anvelope_brands();
    if ($brands) { ?>
      <article class="thumb c0">
        <h1><a href="">Toate marcile</a></h1>
      </article>
      <?php foreach ($brands as $index=>$article) { ?>
        <article class="thumb c<?php echo $index + 1 ?>">
          <figure>
            <?php
              if (function_exists('z_taxonomy_image_url')) {
                //$img = z_taxonomy_image_url($article->term_id);
                $img = 'http://placehold.it/250x150';
                $title = $article->name;
                $link = $article->slug;
                $retina = false;
                include '_responsive-images.php';
              }
            ?>
            <figcaption>
              <a href="<?php echo $link ?>" title="<?php echo $title ?>"><?php echo $title; ?></a>
            </figcaption>
          </figure>
        </article>
      <?php }
    }
  ?>
</section>

<section id="filters">
  <?php
    $anvelopes = get_anvelopes(-1); 
    $d = get_dimensions($anvelopes);
    $i = get_inaltimes($anvelopes);
    $l = get_latimes($anvelopes);
  ?>
  
  <div>
    <h1>Configurator</h1>
    
    <select class="option-set" data-filter-group="latime">
      <option selected data-filter-value="">Toate latimile</option>
		  <?php foreach ($l as $p) { ?>
			  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
		  <?php } ?>
	  </select>
	
	  <select class="option-set" data-filter-group="inaltime">
	    <option selected data-filter-value="">Toate inaltimile</option>
		  <?php foreach ($i as $p) { ?>
			  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
		  <?php } ?>
	  </select>
	
	  <select class="option-set" data-filter-group="diameter">
	    <option selected data-filter-value="">Toate dimensiunile</option>
		  <?php foreach ($d as $p) { ?>
			  <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
		  <?php } ?>
	  </select>
	  
	  <select class="option-set" data-filter-group="meta">
	    <option selected data-filter-value="">Toate produsele</option>
		  <option data-filter-value=".promotie">Reduceri</option>
		  <option data-filter-value=".bestseller">Cele mai vandute</option>
	  </select>
  </div>
</section>


<section id="anvelope">
  <?php 
    if ($anvelopes) { ?>
      <?php foreach ($anvelopes as $index=>$article) { ?>
        <?php $klass = get_article_class($article); ?>
        <article class="<?php echo implode(' ', $klass); ?> thumb">
          <?php 
            $image_size = 'medium';
            include '_article.php';
          ?>
       </article>
    <?php } ?>
  <?php } ?>
</section>

<?php get_footer(); ?>
