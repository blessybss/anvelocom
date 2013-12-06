<?php

// Functions for the Anvelocom plugin
// --------------------------------------------------------------------------------


// Definitions


define("META_ANVELOPE_DIMENSION", 'anvelope-diametru');
define("META_ANVELOPE_LATIME", 'anvelope-latime');
define("META_ANVELOPE_INALTIME", 'anvelope-inaltime');
define("META_ANVELOPE_BRAND", 'anvelope-brand');
define("META_ANVELOPE_PROFIL", 'anvelope-profil');

global $FILTERS_ANVELOPE;
global $FILTERS_ANVELOPE_LABELS;
global $FILTERS_ANVELOPE_LABELS2;
global $FILTERS_ANVELOPE_RELATIONS;
$FILTERS_ANVELOPE = array(META_ANVELOPE_LATIME, META_ANVELOPE_INALTIME, META_ANVELOPE_DIMENSION, META_ANVELOPE_PROFIL, META_ANVELOPE_BRAND);
$FILTERS_ANVELOPE_LABELS = array('Latime anvelopa', 'Inaltime anvelopa', 'Diametru janta', 'Profil', 'Marca');
$FILTERS_ANVELOPE_LABELS2 = array('Toate latimile', 'Toate inaltimile', 'Toate dimensiunile', 'Toate profilurile', 'Toate marcile');



define("META_JENTI_DIMENSION", 'Latime/Diametru');
define("META_JENTI_BRAND", 'Marca/Model');
define("META_JENTI_PCD", 'PCD');
$FILTERS_JENTI = array(META_JENTI_DIMENSION, META_JENTI_BRAND, META_JENTI_PCD);
$FILTERS_JENTI_LABELS = array('Latime/Diametru', 'Marca/Model', 'PCD');
$FILTERS_JENTI_LABELS2 = array('Toate Latime/Diametru', 'Toate Marca/Model', 'Toate PCD');

define("META_TUNING_BRAND", 'Marca auto');
define("META_TUNING_MODEL", 'Model');
define("META_TUNING_MOTOR", 'Motorizare');
$FILTERS_TUNING = array(META_TUNING_BRAND, META_TUNING_MODEL, META_TUNING_MOTOR);
$FILTERS_TUNING_LABELS = array('Marca auto', 'Model', 'Motorizare');
$FILTERS_TUNING_LABELS2 = array('Toate marcile', 'Toate modelurile', 'Toate motorizarile');

global $FILTERS;
global $FILTERS_LABELS;
global $FILTERS_LABELS2;
$FILTERS = array($FILTERS_ANVELOPE, $FILTERS_JENTI, $FILTERS_TUNING);
$FILTERS_LABELS = array($FILTERS_ANVELOPE_LABELS, $FILTERS_JENTI_LABELS, $FILTERS_TUNING_LABELS);
$FILTERS_LABELS2 = array($FILTERS_ANVELOPE_LABELS2, $FILTERS_JENTI_LABELS2, $FILTERS_TUNING_LABELS2);



// Do the filtering on the user interface
//
function isotope_filter_ajax() {
  $nonce = $_POST['nonce'];  
  if (wp_verify_nonce($nonce, 'anvelope')) {
  
    $filter = strval($_POST['filter']);
    $filter_value = strval($_POST['filter_value']);
    echo $filter;
    echo $filter_value;
    
    if ($filter && $filter_value) {
      $relations = avc_get_filter_relationships($filter_value, $filter, 'filter_anvelope');
      print_r($relations);
      
      $ret = array(
        'success' => true,
        'message' => 'Ok',
        'relations' => $relations
      );
    } else {
      $ret = array(
        'success' => false,
        'message' => 'Filter error'
      );
    }
  } else {
    $ret = array(
      'success' => false,
      'message' => 'Nonce error'
    );
  }
  
  $response = json_encode($ret);
  header( "Content-Type: application/json" );
  echo $response;
  exit;
}
add_action('wp_ajax_isotope_filter_ajax', 'isotope_filter_ajax');
add_action( 'wp_ajax_nopriv_isotope_filter_ajax', 'isotope_filter_ajax' );



// Do the filtering on the Admin interface
//
function anvelocom_filter_ajax() {
  $nonce = $_POST['nonce'];  
  if (wp_verify_nonce($nonce, 'anvelope')) {
  
    $filter = strval($_POST['filter']);
    $filter_value = strval($_POST['filter_value']);
    
    if ($filter && $filter_value) {
      $relations = avc_get_filter_relationships($filter_value, $filter, 'filter_anvelope');
      $nonce = 'anvelope';
      
      global $SPECIAL_CATEGORIES;
      $articles = get_posts_from_category($SPECIAL_CATEGORIES[0], -1);
      $filters = avc_get_filters(0, $articles); 
      include 'form.php';
    } 
  }
  exit;
}
add_action('wp_ajax_anvelocom_filter_ajax', 'anvelocom_filter_ajax');
add_action( 'wp_ajax_nopriv_anvelocom_filter_ajax', 'anvelocom_filter_ajax' );



// Save relationships for a filter
function avc_save($post) {
  $ret = '';
  
  // Get and transform $_POST data
  $filter = $post['filter'];
  $filter2 = avc_remove_filter_prefix($filter);
  $filter_value = $post['filter_value'];
  $relations = $post['relations'];
  
  // Remove existing data before save
  avc_delete('filter_anvelope', $filter2, $filter_value);
  
  // Do save
  foreach ($relations as $column => $relation) {
    $column2 = avc_remove_filter_prefix($column);
    foreach ($relation as $r) {
      $ret = avc_insert('filter_anvelope', $filter2, $filter_value, $column2, $r);
    }
  }
  
  return $ret;
}


// Insert a single relationship into the db
function avc_insert($table, $key1, $value1, $key2, $value2) {
  $fields = '(' . $key1 . ',' . $key2 . ')';
  $values = '(%s, %s)';
  $data = array($value1, $value2);

  global $wpdb;
  $table = $wpdb->prefix . $table;
  
  $ret = $wpdb->query( 
  	$wpdb->prepare( 
  		"INSERT INTO $table $fields VALUES $values ", $data
  	)
	);
	
	return ($ret != false) ? "OK" : "Error";
}

// Delete existing relationhips for an item
// - this is called before save
// - on save all relationships are rewritten, ir first deleted then saved
function avc_delete($table, $key, $value) {
  global $wpdb;
  $table = $wpdb->prefix . $table;
  
  $ret = $wpdb->query( 
  	$wpdb->prepare( 
  		"DELETE FROM $table WHERE $key = '" . $value . "'", array()
  	)
	);
	
	return ($ret != false) ? "OK" : "Error";
}


// Get relationships for a filter
// - params: 265, anvelope-latime, filter_anvelope
// - returns an array of arrays, each array showing a relationship
function avc_get_filter_relationships($value, $filter, $table) {
  $ret = array();
  
  global $wpdb;
  global $FILTERS_ANVELOPE;
  $key = avc_remove_filter_prefix($filter);
  
  foreach ($FILTERS_ANVELOPE as $filters) {
    if ($filters != $filter) {
      $column = avc_remove_filter_prefix($filters);
      $ret[] = $wpdb->get_results(
        "SELECT $column FROM " . $wpdb->prefix . $table . " WHERE " . $key . " = '" . $value . "'"     
      );
    }
  }
  
  return avc_prettify_relationships($ret);
}


// Make a good looking relationships table
function avc_prettify_relationships($relations) {
  $ret = array();
  
  foreach ($relations as $relation) {
    foreach ($relation as $r) {
      $key = key($r);
      $value = $r->$key;
      if ($value) {
        $ret[$key][] = $value;
      }
    }
  }
  
  return $ret;
}

// Checks if a checkbox must be checked or not
// - params: checkbox value, filter, relationships array
function avc_get_checked($checkbox, $filter, $relations) {
  $filter = avc_remove_filter_prefix($filter);
  if (array_key_exists($filter, $relations)) {
    if (empty($relations[$filter])) {
      return '';
    } else {
      return (in_array($checkbox, $relations[$filter])) ? "checked" : "";
    }
  }
}


// Get filters 
// - returns meta fields for $filter_id from all $articles
// - ie. all filter values for anvelope
function avc_get_filters($filter_id, $articles) {
  global $FILTERS;
  
  $ret = array();
  foreach ($FILTERS[$filter_id] as $filter) {
    $ret[] = get_filter_values($filter, $articles);
  }
  
  return $ret;
}


// Get filter labels
// - returns <li> items
function avc_get_filter_labels($filter_id) {
  global $FILTERS_LABELS;
  
  $ret = '';
  foreach ($FILTERS_LABELS[$filter_id] as $label) {
    $ret .= '<li>' . $label . '</li>';
  }
  
  return $ret;
}


// Remove prefix for filter to use as database key
// - ie: anvelope-latime -> latime
function avc_remove_filter_prefix($filter) {
  $key = explode('-', $filter);
  return $key[1];
}
  



?>
