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
    
    // Get the filter
    var $filter_value = $this.html();
    var $filter = jQuery(this).attr('data-filter-group');
    
    // Do the AJAX call
    var nonce = jQuery('.wp-admin #anvelope #filters').find('#nonce').attr("value");
    jQuery.post(
      anvelocom.ajaxurl, 
      {
        'action' : 'anvelocom_filter_ajax',
        'nonce' : nonce,
        'filter' : $filter,
        'filter_value' : $filter_value
      }, 
      function(response) {        
        jQuery('.wp-admin #anvelope #relationships').empty().append(response);  
        
        // Show checkboxes, unless for this current filter
        jQuery('.wp-admin #anvelope #relationships #relation.' + $filter).css('visibility', 'hidden');
        
        // Add hidden form elements with the current filter data
        jQuery('.wp-admin #anvelope #relationships form input#filter').attr('value', $filter);
        jQuery('.wp-admin #anvelope #relationships form input#filter_value').attr('value', $filter_value);     
      }
    );
  });
});
