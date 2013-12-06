<form action="?page=anvelocom-anvelope" method="post">
  <?php
    global $FILTERS;
    
    foreach ($filters as $index => $filter) { 
      $filter_name = $FILTERS[0][$index]; ?>
      <div id="relation" class="<?php echo $filter_name ?>">
        <?php foreach ($filters[$index] as $p) { 
          $checked = avc_get_checked($p, $filter_name, $relations); ?>
          <input type="checkbox" id="relations[<?php echo $filter_name ?>][]" name="relations[<?php echo $filter_name ?>][]" value="<?php echo $p ?>" <?php echo $checked ?>>
          <?php echo $p ?>
          <br>
        <?php } ?>
      </div>
    <?php } ?>
  
  <input type="hidden" value="<?php echo wp_create_nonce($nonce) ?>" id="nonce" name="nonce">
  <input type="hidden" id="action" name="action" value="submit-form">
  
  <?php // These will be filled by jQuery when a filter is selected ?>
  <input type="hidden" id="filter" name="filter" value="">
  <input type="hidden" id="filter_value" name="filter_value" value="">
  
  <p class="submit">
    <input type="submit" value="Actualizare" id="submit" name="submit">
  </p>
</form>
