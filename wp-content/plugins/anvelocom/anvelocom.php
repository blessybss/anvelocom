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
    
    <?php
      // Prepare articles and filters
      global $SPECIAL_CATEGORIES;
      $articles = get_posts_from_category($SPECIAL_CATEGORIES[0], -1);
      $filters = avc_get_filters(0, $articles); 
    ?>
    
    <div id="filters">
      <?php
        // Display the select boxes
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
      <?php foreach ($filters as $index => $filter) { ?>
        <div id="relation">
          <?php foreach ($filters[$index] as $p) { ?>
            <input type="checkbox" name="<?php echo $p ?>" value="<?php echo $p ?>"><?php echo $p ?>
            <br>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    
    <!--
    <div id="relationships">
      <?php 
        $relationships = avc_get_filter_relationships('265', 'latime', 'anvelope'); 
        
        global $FILTERS_ANVELOPE;
        $current = array_search('latime', $FILTERS_ANVELOPE);
        
        foreach ($relationships as $index => $relation) { ?>
          <div id="relation"> 
            <?php if ($index == $current) {
              echo 'current';
            } else {
              print_r($relation);
            } ?>
          </div>
        <?php } 
      ?>
    </div>
    -->
  
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
  
  $table_name = $wpdb->prefix . "filter_anvelope_inaltime_latime"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    inaltime_id mediumint(9) NOT NULL,
    latime_id mediumint(9) NOT NULL,
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
  
  $table_name = $wpdb->prefix . "filter_anvelope_inaltime_diametru"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    inaltime_id mediumint(9) NOT NULL,
    diametru_id mediumint(9) NOT NULL,
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
  
  $table_name = $wpdb->prefix . "filter_anvelope_latime_diametru"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    latime_id mediumint(9) NOT NULL,
    diametru_id mediumint(9) NOT NULL,
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
