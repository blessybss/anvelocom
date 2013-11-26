<?php 
  // Decide on which page we are: Anvelope, Jenti, ... and set up variables for filters
  global $post;
  $slug = get_post($post)->post_name;
  $page = array_search($slug, $SPECIAL_PAGES);
?>

<?php if (!empty($FILTERS_LABELS[$page])) { ?>
  <section id="filters">
    <h2>Configurator</h2>
    
    <ul id="labels">
      <?php foreach ($FILTERS_LABELS[$page] as $label) { ?>
        <li><?php echo $label ?></li>
      <?php } ?>
    </ul>
    
    <?php
      // Prepare articles and filters
      $articles = get_posts_from_category($SPECIAL_CATEGORIES[$page], -1);
      $filters = array();
      foreach ($FILTERS[$page] as $filter) {
        $filters[] = get_filter_values($filter, $articles);
      }
    ?>
    
    <?php
      // Display the select boxes
      foreach ($FILTERS_LABELS2[$page] as $index => $select) { ?>
        <label class="select"> 
          <select class="option-set" data-filter-group="<?php echo $FILTERS[$page][$index] // latime ?>">
            <option selected data-filter-value=""><?php echo $select // Toate latimile ?></option>
            <?php foreach ($filters[$index] as $p) { ?>
		          <option data-filter-value=".<?php echo $p ?>"><?php echo $p ?></option>
	          <?php } ?>
          </select>
        </label> 
      <?php }
    ?>
  </section>

  <?php 
    $title = 'Rezultate';
    $link = '';
    $id = 'results';
    $filters = true; 
    include '_articles.php';
  ?>
<?php } ?>

<?php 
  $parent_slug = $SPECIAL_CATEGORIES[$page];  
  include '_brands.php';
?>

