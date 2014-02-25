<?php

// Functions for the Anvelocom plugin
// --------------------------------------------------------------------------------


// Definitions

// Anvelope
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
$FILTERS_ANVELOPE_LABELS2 = array('Toate latimile', 'Toate inaltimile', 'Toate dimensiunile', 'Toate profilele', 'Toate marcile');


// Jenti
define("META_JENTI_DIMENSION", 'jenti-latime');
define("META_JENTI_BRAND", 'jenti-marca');
define("META_JENTI_PCD", 'jenti-pcd');
$FILTERS_JENTI = array(META_JENTI_DIMENSION, META_JENTI_BRAND, META_JENTI_PCD);
$FILTERS_JENTI_LABELS = array('Latime/Diametru', 'Marca/Model', 'PCD');
$FILTERS_JENTI_LABELS2 = array('Toate Latime/Diametru', 'Toate Marca/Model', 'Toate PCD');


// Tuning
define("META_TUNING_BRAND", 'tuning-marca');
define("META_TUNING_MODEL", 'tuning-model');
define("META_TUNING_MOTOR", 'tuning-motorizare');
$FILTERS_TUNING = array(META_TUNING_BRAND, META_TUNING_MODEL, META_TUNING_MOTOR);
$FILTERS_TUNING_LABELS = array('Marca auto', 'Model', 'Motorizare');
$FILTERS_TUNING_LABELS2 = array('Toate marcile', 'Toate modelurile', 'Toate motorizarile');


// Global array
global $FILTERS;
global $FILTERS_LABELS;
global $FILTERS_LABELS2;
$FILTERS = array($FILTERS_ANVELOPE, $FILTERS_JENTI, $FILTERS_TUNING);
$FILTERS_LABELS = array($FILTERS_ANVELOPE_LABELS, $FILTERS_JENTI_LABELS, $FILTERS_TUNING_LABELS);
$FILTERS_LABELS2 = array($FILTERS_ANVELOPE_LABELS2, $FILTERS_JENTI_LABELS2, $FILTERS_TUNING_LABELS2);

global $TABLES;
$TABLES = array('anvelope', 'jenti', 'tuning');






// Do the filtering on the user interface
//
function isotope_filter_ajax() {
  $nonce = $_POST['nonce'];  
  if (wp_verify_nonce($nonce, 'anvelope')) {
  
    $filtered_values = strval($_POST['filtered_values']);
    
    $relations = avc_get_filter_relationships($filtered_values);
    $ret = array(
      'success' => true,
      'message' => 'Ok',
      'relations' => $relations
    ); 
   
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



// Get relationships for a filter
// - filter_values are like anvelope-latime:.37,anvelope-inaltime:undefined,anvelope-diametru:undefined,anvelope-profil:undefined,anvelope-brand:undefined,
// - returns an array of arrays, each array showing a relationship
function avc_get_filter_relationships($filter_values) {
  $ret = array();
  
  global $wpdb;
  
  // Transform filter_values into an array
  $filters = explode(',', $filter_values);
  
  // Get table name
  $table = explode('-', $filters[0]);
  $table_name = $wpdb->prefix . "filter_" . $table[0];
    
  // Loop through all filters
  foreach ($filters as $filter) {
    // Get filter name and value
    $split = explode(':', $filter);
    
    print_r($split);
  }
  

  /*
  if (!empty($filtered_values_arr)) {
    $filtered_values_arr = explode(',',$filtered_values_arr);
    foreach ($filtered_values_arr as $key=>$value) {
      if ($key > 0) {
        $f_key = $filtered_values_arr[$key-1];
        $f_value = $filtered_values_arr[$key];
        $f_value =substr($f_value,1, strlen($f_value)); 
        if ($key < 2) {
          $f_key = avc_remove_filter_prefix($f_key);
          if ($f_value)
            $where_clause .= " WHERE " . $f_key . " = '" . $f_value . "'";
        } else {
          if (($key-1) % 2 == 0){
            $f_key = avc_remove_filter_prefix($f_key);
            if ($f_value)
              if (strpos($where_clause, 'WHERE') !== false) 
                $where_clause .= " AND " . $f_key . " = '" . $f_value . "'";
          } else
            continue;
        }
      }
    }
  }

  foreach ($FILTERS[$table_index] as $filters) {
    if ($filters != $filter) {
      $column = avc_remove_filter_prefix($filters);
      $ret[] = $wpdb->get_results(
        "SELECT $column FROM " . $wpdb->prefix . $table . $where_clause     
      );
    }
  }
  */

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
