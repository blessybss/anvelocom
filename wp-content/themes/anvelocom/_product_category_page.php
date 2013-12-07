<?php 
  // Decide on which page we are: Anvelope, Jenti, ... and set up variables for filters
  global $post;
  $slug = get_post($post)->post_name;
  $page = array_search($slug, $SPECIAL_PAGES);
?>

<?php if (!empty($FILTERS_LABELS[$page])) { ?>
  <section id="filters">
    <header>
      <h2>Configurator</h2>
    </header>
    
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
    
    <div id="selects">
      <?php
        // Display the select boxes
        foreach ($FILTERS_LABELS2[$page] as $index => $select) { ?>
          <label class="select"> 
            <select class="option-set" data-filter-group="<?php echo $FILTERS[$page][$index] // latime ?>">
              <option selected data-filter-value=""><?php echo $select // Toate latimile ?></option>
              <?php foreach ($filters[$index] as $p) { ?>
		            <option data-filter-value=".<?php echo string_to_classname($p) ?>"><?php echo $p ?></option>
	            <?php } ?>
            </select>
          </label> 
        <?php }
      ?>
      <input type="hidden" value="<?php echo wp_create_nonce('anvelope') ?>" id="nonce" name="nonce">
      <input type="hidden" value="<?php echo admin_url('admin-ajax.php'); ?>" id="ajaxurl" name="ajaxurl">
      <input type="hidden" value="<?php echo $page; ?>" id="table_index" name="table_index">
    </div>
  </section>

  <?php 
    $title = 'Rezultate';
    $link = '';
    $id = 'results';
    $filters = $FILTERS[$page]; 
    include '_articles.php';
  ?>
<?php } ?>

<?php 
  $parent_slug = $SPECIAL_CATEGORIES[$page];  
  include '_brands.php';
?>

