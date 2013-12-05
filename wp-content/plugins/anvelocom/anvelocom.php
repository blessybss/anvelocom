<?php
/*
  Plugin Name: Anvelocom Filters
  Plugin URI: http://anvelocom.ro
  Description: A filter plugin for Anvelocom
  Version: 0.0.1
  Author: Csongor Bartus
  Author URI: http://its-csongor.com
  License: GPL2
*/





// Admin menu & Plugin init
//
function anvelocom_admin_menu() {  
  add_menu_page('Dashboard', 'Anvelocom', 'delete_others_posts', 'anvelocom-menu', 'anvelocom_main_page' );     
  
  // This makes the first submenu to be 'Overview' instead of the default 'Anvelocom'
  // - http://wordpress.stackexchange.com/questions/26499/naming-admin-menus-and-submenus
  add_submenu_page("anvelocom-menu", "Descriere plugin", "Descriere plugin", 'delete_others_posts', "anvelocom-menu", "anvelocom_main_page");
  add_submenu_page("anvelocom-menu", "Anvelope", "Anvelope", 'delete_others_posts', "anvelocom-anvelope", "anvelocom_anvelope_page");  
  add_submenu_page("anvelocom-menu", "Jenti", "Jenti", 'delete_others_posts', "anvelocom-jenti", "anvelocom_jenti_page"); 
  add_submenu_page("anvelocom-menu", "Tuning", "Tuning", 'delete_others_posts', "anvelocom-tuning", "anvelocom_tuning_page"); 
  
} 
add_action('admin_menu', 'anvelocom_admin_menu');


// Dashboard
// --------------------------------------------------------------------------------

function anvelocom_main_page() {
  if (!current_user_can('delete_others_posts'))  {
    wp_die( 'Nu aveti drepturi suficiente de acces.' );
  } ?>
  
  <h1>Descriere plugin</h1>
  
  <?php  
}






// Include parts of the plugin
include_once(plugin_dir_path( __FILE__ ) . 'anvelocom-functions.php');


// Include admin.css, admin.js 
function anvelocom_admin_scripts() {
	wp_register_style( 'anvelocom-admin', plugins_url('anvelocom.css', __FILE__) );
	wp_enqueue_style( 'anvelocom-admin' );
	wp_enqueue_script('anvelocom', plugins_url('anvelocom.js', __FILE__), array('jquery'));
	wp_localize_script( 'anvelocom', 'anvelocom', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}  
add_action('admin_print_styles', 'anvelocom_admin_scripts');



// Anvelope
// --------------------------------------------------------------------------------

function anvelocom_anvelope_page() { ?>
  <section id="anvelope" class="filter">
    <h1>Anvelope</h2>
    
    <?php $nonce = 'anvelope' ?>
    
    <?php
      // Prepare articles and filters
      global $SPECIAL_CATEGORIES;
      $articles = get_posts_from_category($SPECIAL_CATEGORIES[0], -1);
      $filters = avc_get_filters(0, $articles); 
    ?>
    
    <div id="filters">
      <?php
        // Display the select boxes
        //
        global $FILTERS_LABELS2;
        global $FILTERS;
        
        foreach ($FILTERS_LABELS2[0] as $index => $select) { ?>
          <label class="select"> 
            <select class="option-set" data-filter-group="<?php echo $FILTERS[0][$index] // latime ?>">
              <option selected data-filter-value=""><?php echo $select // Toate latimile ?></option>
              <?php foreach ($filters[$index] as $p) { ?>
	              <option data-filter-value=".<?php echo string_to_classname($p) ?>"><?php echo $p ?></option>
              <?php } ?>
            </select>
          </label> 
        <?php }
      ?>
    </div>
  
    <div id="relationships">
      <form action="?page=anvelocom-anvelope" method="post">
        <?php $relations = avc_get_filter_relationships('10,5', 'anvelope-inaltime', 'filter_anvelope'); print_r($relations); ?>
        <?php foreach ($filters as $index => $filter) { ?>
          <div id="relation" class="<?php echo $FILTERS[0][$index] ?>">
            <?php foreach ($filters[$index] as $p) { ?>
              <input type="checkbox" id="relations[<?php echo $FILTERS[0][$index] ?>][]" name="relations[<?php echo $FILTERS[0][$index] ?>][]" value="<?php echo $p ?>"><?php echo $p ?>
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
    </div>
    
    
    <?php 
      // Save the relationships
      //
      if (($_POST) && ($_POST['action'] == 'submit-form')) {
        if (wp_verify_nonce( $_POST['nonce'], $nonce )) {
          print_r($_POST);
          avc_save($_POST);
        }
      }
    ?>
  </section>
<?php }



// Jenti
// --------------------------------------------------------------------------------

function anvelocom_jenti_page() {
  //anvelocom_admin_display_submenu_page("Jenti", "jenti", new Jenti_Table(), true, true, true);
}


// Tuning
// --------------------------------------------------------------------------------

function anvelocom_tuning_page() {
  //anvelocom_admin_display_submenu_page("Tuning", "tuning", new Tuning_Table(), true, false, true);
}





// Database tables
// --------------------------------------------------------------------------------


// Create database tables
function anvelocom_tables() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  
  global $FILTERS_ANVELOPE;
  
  $fields = '';
  foreach ($FILTERS_ANVELOPE as $filter) {
    $fields .= avc_remove_filter_prefix($filter);
    $fields .= ' varchar(255), ';
  }
  
  $table_name = $wpdb->prefix . "filter_anvelope"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    $fields
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
}
register_activation_hook(__FILE__,'anvelocom_tables');


// Destroy database tables
function anvelocom_deactivate() {
  
}
register_deactivation_hook( __FILE__, 'anvelocom_deactivate' );
?>
