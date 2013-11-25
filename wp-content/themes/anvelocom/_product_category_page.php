
<section id="filters">
  <h2>Configurator</h2>
  
  <ul id="labels">
    <li>Latime anvelopa</li>
    <li>Inaltime anvelopa</li>
    <li>Diametru janta</li>
    <li>Marca</li>
    <li>Profil</li>
  </ul>
  
  
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


<section id="results">
  <h2>Rezultate</h2>
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

<?php include '_brands.php' ?>

