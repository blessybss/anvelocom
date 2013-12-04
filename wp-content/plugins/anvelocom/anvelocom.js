jQuery(document).ready(function() {
  
  // Selectbox change
  jQuery('.wp-admin #anvelope #filters select').on('change', function (e) {
    var $this = jQuery("option:selected", this);
    
    // don't proceed if already selected
    if ($this.hasClass('selected')) {
      return;
    }
  
    // disable all select boxes
    jQuery('.wp-admin #anvelope #filters select').attr('disabled', 'disabled');
    
    // Get filter value
    var $filter_value = $this.html();
    
    // Get filter
    var $filter = jQuery(this).attr('data-filter-group');
    alert($filter + $filter_value);
  });
});
