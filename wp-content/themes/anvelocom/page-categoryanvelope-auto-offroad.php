<?php get_header(); ?>

<?php include '_intro.php' ?>


<section id="filters">
  <h1>Configurator</h1>
  
  <!--
  <div id="labels">
    <label>Latime anvelopa</label>
    <label>Inaltime anvelopa</label>
    <label>Diametru janta</label>
    <label>Marca</label>
    <label>Profil</label>
  </div>
  -->
  
  <?php
    $anvelopes = get_anvelopes(-1); 
    $d = get_dimensions($anvelopes);
    $i = get_inaltimes($anvelopes);
    $l = get_latimes($anvelopes);
    $b = get_brand($anvelopes);
    $pr = get_profs($anvelopes);
  ?>
  
  <label class="select">  
    <select class="option-set" data-filter-group="latime">
      <option selected data-filter-value="">Toate latimile</option>
	    <?php foreach ($l as $p) { ?>
		    <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	    <?php } ?>
    </select>
  </label>

  <label class="select">
    <select class="option-set" data-filter-group="inaltime">
      <option selected data-filter-value="">Toate inaltimile</option>
	    <?php foreach ($i as $p) { ?>
		    <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	    <?php } ?>
    </select>
  </label>
  
  <label class="select">
    <select class="option-set" data-filter-group="diameter">
      <option selected data-filter-value="">Toate dimensiunile</option>
	    <?php foreach ($d as $p) { ?>
		    <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	    <?php } ?>
    </select>
  </label>
  
  <label class="select">
    <select class="option-set" data-filter-group="marca">
      <option selected data-filter-value="">Toate marcile</option>
	    <?php foreach ($b as $p) { ?>
		    <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	    <?php } ?>
    </select>
  </label>
  
  <label class="select">
    <select class="option-set" data-filter-group="profil">
      <option selected data-filter-value="">Toate profilurile</option>
	    <?php foreach ($pr as $p) { ?>
		    <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	    <?php } ?>
    </select>
  </label>
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


<section id="brands">
  <?php include '_brands.php' ?>
</section>

<?php get_footer(); ?>
