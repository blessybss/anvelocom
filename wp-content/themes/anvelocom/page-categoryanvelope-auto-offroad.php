<?php get_header(); ?>

<h1>Anvelope</h1>

<section id="brands">
  <?php include '_brands.php' ?>
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
