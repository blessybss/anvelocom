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




// Include parts of the plugin

// General admin functions
// - it is like a framework (Rails) to display, edit, add, manage tables
// - each table has its own file wich must be included below
include_once(plugin_dir_path( __FILE__ ) . 'admin-framework.php');

include_once(plugin_dir_path( __FILE__ ) . 'anvelopes.php');


// Dashboard
// --------------------------------------------------------------------------------

function anvelocom_main_page() {
  if (!current_user_can('delete_others_posts'))  {
    wp_die( 'Nu aveti drepturi suficiente de acces.' );
  } ?>
  
  <h1>Descriere plugin</h1>
  
  <?php  
}



// Anvelope
// --------------------------------------------------------------------------------

function anvelocom_anvelope_page() {
  anvelocom_admin_display_submenu_page("Anvelope", "anvelope", new Anvelope_Table(), true, true, true);
}



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
  
  $table_name = $wpdb->prefix . "filter_anvelope_latime"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    value tinytext NOT NULL,
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
  
  $table_name = $wpdb->prefix . "filter_anvelope_inaltime"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    value tinytext NOT NULL,
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
  
  $table_name = $wpdb->prefix . "filter_anvelope_diametru"; 
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    value tinytext NOT NULL,
    UNIQUE KEY id (id)
  );";
  dbDelta( $sql );
  
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
