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

$FILTERS_ANVELOPE_RELATIONS = array(
  array('filter_anvelope_inaltime_latime', 'filter_anvelope_latime_diametru'),
  array('filter_anvelope_inaltime_latime', 'filter_anvelope_inaltime_diametru'),
  array('filter_anvelope_latime_diametru', 'filter_anvelope_inaltime_diametru')
);




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



// Save relationships for a filter
function avc_save($post) {
  // Get and transform $_POST data
  $filter = $post['filter'];
  $filter_value = $post['filter_value'];
  $relations = array();
  $relations[] = $post['array_1'];
  $relations[] = $post['array_2'];
  
  print_r($relations);
  
  // Remove prefix for filter to use as database key
  // ie: anvelope-latime -> latime
  $key = explode('-', $filter);
  $key_1 = $key[1];
  
  global $wpdb;
  $wpdb->show_errors();
  
  global $FILTERS_ANVELOPE;
  global $FILTERS_ANVELOPE_RELATIONS;
  $index = array_search($filter, $FILTERS_ANVELOPE);
  
  foreach ($FILTERS_ANVELOPE_RELATIONS[$index] as $i => $table) {
    // Get the other database key
    // - ie: filter_anvelope_inaltime_latime > inaltime, when $key_1 = latime
    $key = explode('_', $table);
    $key_2 = ($key[2] != $key_1) ? $key[2] : $key[3];
    
    $table = $wpdb->prefix . $table;
    
    // (inaltime_id, latime_id)
    $fields = '(' . $key_1 . ',' . $key_2 . ')';
    
    $values = '(%s, %s)';
    
    // array(265, 16);
    $data = array();
    $data[] = $filter_value;
    
    foreach ($relations[$i] as $r) {
      $data[1] = $r;
      print_r($data);
      
      $ret = $wpdb->query( 
        $wpdb->prepare( 
      		"INSERT INTO $table $fields VALUES $values", $data
      	)
    	);
    	
    	$msg = ($ret != false) ? "OK" : "Error";
      echo $msg;
    }
    
  }
}

// Get relationships for a filter
// - params: 265, latime, anvelope
// - returns an array of arrays, each array showing a relationship
function avc_get_filter_relationships($value, $filter, $group) {
  $ret = array();
  
  global $wpdb;
  global $FILTERS_ANVELOPE;
  global $FILTERS_ANVELOPE_RELATIONS;
  $index = array_search($filter, $FILTERS_ANVELOPE);
  
  // Remove prefix for filter to use as database key
  // ie: anvelope-latime -> latime
  $key = explode('-', $filter);
  
  $ret[] = $wpdb->get_results(
    "SELECT * FROM " . $wpdb->prefix . $FILTERS_ANVELOPE_RELATIONS[$index][0] . " WHERE " . $key[1] . " = " . $value      
  );
  $ret[] = $wpdb->get_results(
    "SELECT * FROM " . $wpdb->prefix . $FILTERS_ANVELOPE_RELATIONS[$index][1] . " WHERE " . $key[1] . " = " . $value      
  );
  
  return $ret;
}


// Get filters 
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




?>
