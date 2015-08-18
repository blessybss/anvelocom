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

//Added options for import



// Admin menu & Plugin init
//
function anvelocom_admin_menu() {
  add_menu_page('Dashboard', 'Anvelocom', 'delete_others_posts', 'anvelocom-menu', 'anvelocom_main_page' );

  // This makes the first submenu to be 'Overview' instead of the default 'Anvelocom'
  // - http://wordpress.stackexchange.com/questions/26499/naming-admin-menus-and-submenus
  add_submenu_page("anvelocom-menu", "Descriere plugin", "Descriere plugin", 'delete_others_posts', "anvelocom-menu", "anvelocom_main_page");
  add_submenu_page("anvelocom-menu", "Filtre", "Filtre", 'delete_others_posts', "anvelocom-anvelope", "anvelocom_anvelope_page");
  add_submenu_page("anvelocom-menu", "Eshop convert", "Eshop convert", 'delete_others_posts', "anvelocom-eshopconvert", "anvelocom_eshopconvert_page");
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




// Eshop convert
// --------------------------------------------------------------------------------

function anvelocom_eshopconvert_page() { ?>
  <section class='eshop-convert'>
    <h1>Eshop convert</h1>

    <form action="?page=anvelocom-eshopconvert" method="post">
      <input type="hidden" value="<?php echo wp_create_nonce('anvelocom-convert') ?>" id="nonce" name="nonce">
      <input type="hidden" id="action" name="action" value="submit-form">
      <input type="hidden" id="index" name="index" value="0">
      <input type="submit" value="Convert" id="submit" name="submit">
    </form>

    <?php
      // Convert
      //
      if (($_POST) && ($_POST['action'] == 'submit-form')) {
        if (wp_verify_nonce( $_POST['nonce'], 'anvelocom-convert' )) {
          echo avc_eshop_convert();
        }
      }
    ?>
  </section>
<?php }


// Filtre
// --------------------------------------------------------------------------------

function anvelocom_anvelope_page() { ?>
  <section id="anvelope" class="filter">
    <h1>Filtre</h2>

    <form action="?page=anvelocom-anvelope" method="post">
      <input type="hidden" value="<?php echo wp_create_nonce('anvelocom') ?>" id="nonce" name="nonce">
      <input type="hidden" id="action" name="action" value="submit-form">
      <input type="hidden" id="index" name="index" value="0">
      <input type="submit" value="Anvelope" id="submit" name="submit">
    </form>

    <form action="?page=anvelocom-anvelope" method="post">
      <input type="hidden" value="<?php echo wp_create_nonce('anvelocom') ?>" id="nonce" name="nonce">
      <input type="hidden" id="action" name="action" value="submit-form">
      <input type="hidden" id="index" name="index" value="1">
      <input type="submit" value="Jenti" id="submit" name="submit">
    </form>

    <form action="?page=anvelocom-anvelope" method="post">
      <input type="hidden" value="<?php echo wp_create_nonce('anvelocom') ?>" id="nonce" name="nonce">
      <input type="hidden" id="action" name="action" value="submit-form">
      <input type="hidden" id="index" name="index" value="2">
      <input type="submit" value="Tuning" id="submit" name="submit">
    </form>

    <?php
      // Generate the relationships
      //
      if (($_POST) && ($_POST['action'] == 'submit-form')) {
        if (wp_verify_nonce( $_POST['nonce'], 'anvelocom' )) {
          $index = $_POST['index'];

          echo avc_generate_relationships($index);
        }
      }
    ?>
  </section>
<?php }




// Database tables
// --------------------------------------------------------------------------------


// Create database tables
function anvelocom_tables() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  global $TABLES;
  global $FILTERS;

  foreach ($TABLES as $index => $table) {
    $fields = '';
    foreach ($FILTERS[$index] as $filter) {
      $fields .= avc_remove_filter_prefix($filter);
      $fields .= ' varchar(255), ';
    }

    $table_name = $wpdb->prefix . "filter_" . $table;
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      $fields
      UNIQUE KEY id (id)
    );";
    dbDelta($sql);
  }
}
register_activation_hook(__FILE__,'anvelocom_tables');


// Destroy database tables
function anvelocom_deactivate() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  global $TABLES;
  foreach ($TABLES as $table) {
    $table_name = $wpdb->prefix . "filter_" . $table;
    $sql = "DROP TABLE $table_name";
    dbDelta($sql);
  }
}
register_deactivation_hook( __FILE__, 'anvelocom_deactivate' );
?>
