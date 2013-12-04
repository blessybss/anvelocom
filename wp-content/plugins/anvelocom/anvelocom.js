jQuery(document).ready(function() {
  
  // Selectbox change
  jQuery('.wp-admin #anvelope #filters select').on('change', function (e) {
    var $this = jQuery("option:selected", this);
    
    // Don't proceed if already selected
    if ($this.hasClass('selected')) {
      return;
    }
  
    // Disable all select boxes
    jQuery('.wp-admin #anvelope #filters select').attr('disabled', 'disabled');
    
    // Get filter value
    var $filter_value = $this.html();
    
    // Get filter
    var $filter = jQuery(this).attr('data-filter-group');
    
    // Show checkboxes, unless for this current filter
    jQuery('.wp-admin #anvelope #relationships').show();
    jQuery('.wp-admin #anvelope #relationships #relation.' + $filter).css('visibility', 'hidden');
    
    // Add hidden elements with the current filter data
    jQuery('.wp-admin #anvelope #relationships form input#filter').attr('value', $filter);
    jQuery('.wp-admin #anvelope #relationships form input#filter_value').attr('value', $filter_value);
  });
});
