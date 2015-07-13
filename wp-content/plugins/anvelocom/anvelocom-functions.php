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





// Functions for the admin interface

// Convert normal posts to eshop products
function avc_eshop_convert() {
  return 'convert..';
}


// Generate relationships for filters
// - $index: which filter to generate the relationhips for
function avc_generate_relationships($index) {
  $result = '';

  // Get the filters
  global $SPECIAL_CATEGORIES;
  global $FILTERS;
  global $TABLES;
  $articles = get_posts_from_category($SPECIAL_CATEGORIES[$index], -1);
  $filters = $FILTERS[$index];

  global $wpdb;
  $table = $wpdb->prefix . 'filter_' . $TABLES[$index];

  // First remove all existing data ....
  $ret = $wpdb->query(
    $wpdb->prepare(
      "TRUNCATE TABLE $table", array()
    )
  );
  ($ret != false) ? $result .= "OK " : $result .= "Error ";


  // Now add relationships
  $fields = '(';
  foreach ($filters as $filter) {
    $fields .= avc_remove_filter_prefix($filter) . ',';
  }
  $fields = rtrim($fields, ",") . ')';


  foreach ($articles as $article) {
    $relations = array();
    $values = '(';
    foreach ($filters as $filter) {
      $filter_value = get_filter_value($filter, $article, true);
      if ($filter_value)
          $values .= '%s,';
      else	$values .= '"NaV",'; //Not a value: property meta value not set... by iBB!
      $relations = array_merge($relations, $filter_value);
    }

    $values = rtrim($values, ",") . ')';

    // convert 10,5 to 10-5 and BF Goodrich to bf-goodrich to match HTML class name conventions in order to be usable with the Isotope plugin which filters through class names
    $relations= array_map("string_to_classname", $relations);
    if (!empty($relations)) {
      $ret = $wpdb->query(
        $wpdb->prepare(
          "INSERT INTO $table $fields VALUES $values ", $relations
        )
      );
      ($ret != false) ? $result .= "OK " : $result .= "Error ";
    }
  }

  return $result;
}






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
// The algorithm
// 1. when a filter is active all other select boxes are filtered according to this relationship
// 2. when there are two or more filters active all results are intersected again
function avc_get_filter_relationships($filter_values) {
  $ret = array();

  global $wpdb;
  global $TABLES;
  global $FILTERS;

  // Transform filter_values into an array
  $filters = explode(',', $filter_values);


  // Determine which filter is used, and connect with the underlying database table
  $split = explode(':', $filters[0]); // anvelope-latime
  $name = explode('-', $split[0]); // anvelope
  $index = array_search($name[0], $TABLES); // 0
  $filter_column_names = $FILTERS[$index]; // ['anvelope-latime', .... 'amvelope-brand']
  $table = $wpdb->prefix . 'filter_' . $name[0]; // wp_filter_anvelope


  // 0. Initialize the return arrays
  // - each array will contain all elements by default
  // - later these will be intersected when looping through the filters
  foreach ($filter_column_names as $index => $filter_column_name) {
    $column = avc_remove_filter_prefix($filter_column_name);
    $query = $wpdb->get_results(
      "SELECT $column FROM " . $table
    );
    $ret[$index] = array_unique(avc_prettify_single_relation($query));
  }

  // 1. Loop through all filters individually
  // - intersect the return arrays with relationships from the database
  foreach ($filters as $filter) {
    // Get filter name and value
    // returns: [0] => anvelope-latime, [1] => .33
    $split = explode(':', $filter);

    $filter_name = $split[0]; // anvelope-latime
    if (isset($split[1])) {
      $filter_value = $split[1]; // .33

      // Do the query
      $column = avc_remove_filter_prefix($filter_name);
      $value = explode('.', $filter_value);

      if (isset($value[1])) {
        foreach ($filter_column_names as $index => $filter_column_name) {
          $column_name = avc_remove_filter_prefix($filter_column_name);

          if ($column != $column_name) {
            $relation = $wpdb->get_results(
              "SELECT " . $column_name . " FROM " . $table . " WHERE " . $column . " ='" . $value[1] . "' "
            );

            $ret[$index] = array_unique(array_intersect($ret[$index], avc_prettify_single_relation($relation)));
          }
        }
      }
    }
  }


  // 2. When there are multiple filters active
  // Build the SQL query's WHERE clause
  $where = '';
  $multiple_filters = 0;
  foreach ($filters as $filter) {
    // Get filter name and value
    // returns: [0] => anvelope-latime, [1] => .33
    $split = explode(':', $filter);

    if (isset($split[1])) {
      $column = avc_remove_filter_prefix($split[0]);
      // Remove . from the value
      // returns .'33' => '33'
      $value = explode('.', $split[1]);

      if (isset($value[1])) {
        $where .= $column . " = '" . $value[1] . "' ";
        $where .= " AND ";
        $multiple_filters++;
      }
    }
  }

  if ($multiple_filters > 1) {
    $where = str_lreplace(" AND ", "", $where);

    // Execute the SQL
    $relations = $wpdb->get_results(
      "SELECT * FROM " . $table . " WHERE " . $where
    );
    $relations = avc_prettify_relationships($relations);

    // intersect the results from 1.) with these new results
    foreach ($filter_column_names as $index => $filter_column_name) {
      $ret[$index] = array_unique(array_intersect($ret[$index], $relations[$index]));
    }
  }


  return $ret;
}

// Make a good looking relationship
// - ie transform an array of objects to simple values
function avc_prettify_single_relation($relation) {
  $ret = array();

  foreach ($relation as $r) {
    $key = key($r);
    $value = $r->$key;
    $ret[] = $value;
  }

  return $ret;
}


// Make a good looking relationships table
// - ie tarnsform an array of arrays of objects into an array of array values
function avc_prettify_relationships($relations) {
  $ret = array();

  foreach ($relations as $relation) {
    $relation = (array) $relation;
    $i = 0;
    foreach ($relation as $key => $value) {
      if ($key != 'id') {
        $ret[$i][] = $value;
        $i++;
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



// Remove the last sybstring in a string
// - http://stackoverflow.com/questions/3835636/php-replace-last-occurence-of-a-string-in-a-string
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

?>
