<?php

// Functions for the Anvelocom plugin
// --------------------------------------------------------------------------------


// Definitions


define("PAGE_ANVELOPE", 'categoryanvelope-auto-offroad');
define("PAGE_JENTI", 'jante-auto-aluminiu-si-tabla');
define("PAGE_TUNING", 'tuning-auto-powertuning');
global $SPECIAL_PAGES;
$SPECIAL_PAGES = array(PAGE_ANVELOPE, PAGE_JENTI, PAGE_TUNING);


define("CATEGORY_ANVELOPE", 'anvelope-auto-offroad');
define("CATEGORY_JENTI", 'jante');
define("CATEGORY_TUNING", 'tuning');
global $SPECIAL_CATEGORIES;
$SPECIAL_CATEGORIES = array(CATEGORY_ANVELOPE, CATEGORY_JENTI, CATEGORY_TUNING);


define("META_ANVELOPE_DIMENSION", 'Dimensiune janta');
define("META_ANVELOPE_LATIME", 'latime');
define("META_ANVELOPE_INALTIME", 'inaltime');
define("META_ANVELOPE_BRAND", 'brand');
define("META_ANVELOPE_PROFIL", 'profil');
$FILTERS_ANVELOPE = array(META_ANVELOPE_LATIME, META_ANVELOPE_INALTIME, META_ANVELOPE_DIMENSION, META_ANVELOPE_BRAND, META_ANVELOPE_PROFIL);
$FILTERS_ANVELOPE_LABELS = array('Latime anvelopa', 'Inaltime anvelopa', 'Diametru janta', 'Marca', 'Profil');
$FILTERS_ANVELOPE_LABELS2 = array('Toate latimile', 'Toate inaltimile', 'Toate dimensiunile', 'Toate marcile', 'Toate profilurile');

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



// Get relationships for a filter
// - params: 265, latime, anvelope
// - returns an array of arrays, each array showing a relationship
function avc_get_filter_relationships($value, $filter, $group) {
  $ret = array();
  
  switch($filter) {
    case 'latime':
      $table_1 = 'filter_anvelope_inaltime_latime';
      $table_2 = 'filter_anvelope_latime_diametru';
      break;
    case 'inaltime':
      $table_1 = 'filter_anvelope_inaltime_latime';
      $table_2 = 'filter_anvelope_inaltime_diametru';
      break;
    case 'diametru':
      $table_1 = 'filter_anvelope_latime_diametru';
      $table_2 = 'filter_anvelope_inaltime_diametru';
      break;  
  }
  
  global $wpdb;
  $result_1 = $wpdb->get_results(
    "SELECT * FROM " . $wpdb->prefix . $table_1 . " WHERE " . $filter . "_id = " . $value      
  );
  
  $result_2 = $wpdb->get_results(
    "SELECT * FROM " . $wpdb->prefix . $table_2 . " WHERE " . $filter . "_id = " . $value      
  );
  
  switch($group) {
    case 'anvelope':
      $ret[] = array();
      $ret[] = $result_1;
      $ret[] = $result_2;
      break;
  }
  
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
