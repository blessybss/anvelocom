
$(document).ready(function() {

  // Hover on product thumb
  $('.articles article.thumb').hover(
    function() {
      $(this).addClass('active');
    }, function() {
      $(this).removeClass('active');
    }
  );


  // Hide / reveal menu on mobiles
  $('#header nav').click(function() {
    if (!($(this).hasClass('active'))) {
      $('#header nav ul').slideDown('slow'); 
      $('#header nav').addClass('active'); 
    }
  });
  
  // Enable clickc on menu items
  // - The hide/reveal function is overwritten here
  $('#header nav a').click(function(e) {
    e.stopPropagation();
  });



  // Scroll to top
  $('#footer nav').click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false; 
  });



  
  // Filter
  // - by using the Isotope plugin
  // - which is initialized below in the window.onload() event
  
  // Cache container
  var $container = $('.page #results');
  
  // Filter items when filter link is clicked
  filters = {};
  $('#filters select').on('change', function (e) {
    var $this = $("option:selected", this);
    
    // don't proceed if already selected
    if ( $this.hasClass('selected') ) {
      return;
    }
  
    var $optionSet = $this.parents('.option-set');
    
    // change selected class
    $optionSet.find('.selected').removeClass('selected');
    $this.addClass('selected');
    
    // store filter value in object
    // i.e. filters.color = 'red'
    var group = $optionSet.attr('data-filter-group');
    filters[ group ] = $this.attr('data-filter-value');
    
    // to take the main category, e.g.: anvelope, jenti, tuning... by iBB!
    var group_cat = group.split("-");
    
    // convert object into array
    var isoFilters = [];
    for ( var prop in filters ) {
      isoFilters.push( filters[ prop ] )
    }
	
    // for correct filtering in filters we transmit all the selections nut just the actual value, iBB!		
    var isoFilters_val = [];
    for ( var prop in filters ) {
      isoFilters_val.push( prop )
      isoFilters_val.push( filters[ prop ] )
    }
    isoFilters_val = isoFilters_val.join(',');

    // Do the Ajax call to show only related filters
    // - this goes through the Anvelocom plugin and not through functions.php
    var value = $this.attr('data-filter-value');    
    
    // If the first option is selected ('Toate latimile') reset this relationship filter
    if (value == '') {
      $this.siblings().prop('disabled', false);
		resetFilters(); 
    } 
    
    var nonce = $('#filters #selects').find('#nonce').attr("value");
    var ajaxurl = $('#filters #selects').find('#ajaxurl').attr("value");
    var table_index = $('#filters #selects').find('#table_index').attr("value");

    $.post(
      ajaxurl, 
      {
        'action' : 'isotope_filter_ajax',
        'nonce' : nonce,
        'filter' : group,
        'table_index' : table_index,
		'filtered_values': isoFilters_val,
      }, 
      function(response) {
        removeFilters(response.relations,group_cat[0]);    
      }
    );
    
    // Do the Isotope filtering
    var selector = isoFilters.join('');	
    $container.isotope({ filter: selector });
    return false;
  });
  
  
  // Filters are removed from selectboxes if they are not in relation with the selected filter
  function removeFilters(relations,categ) {  
    $.each(relations, function(k, v) {
      var select = $('#filters #selects').find("select[data-filter-group='" + categ + "-" + k + "']");        
		
      select.children('option').each( function() {
        var value = $(this).attr('data-filter-value');
        value = value.replace('.', '');
        if (v.indexOf(value) != -1) {
          $(this).prop('disabled', false);
        } else {
          $(this).prop('disabled', true);
        }
      });
      
      // Make 'Toate latimile ...' always active
      select.children('option').first().prop('disabled', false);
      
      console.log(k);
      console.log(v);
    });
  }

  // Filters are resetted when Toate... selected
  function resetFilters() {      
    $('select').each(function() {
      $(this).children('option').first().prop('selected', 'selected'); 
      
      $(this).children('option').each(function(){
        $(this).prop('disabled', false);
      });
    });
  }
  
  
  
  // The window onload script
  // - here we put all scripts which must run after the page is completelly loaded
  $(window).load(function(){
    
    // Initialize isotope filter plugin
    // Set options  
    $container.isotope({
      itemSelector : 'article',
      layoutMode : 'fitRows',
      
      // The CSS animation was too fancy, we've switched to a simpler one
      animationEngine: 'jquery',
      animationOptions: {
         duration: 750,
         easing: 'linear',
         queue: false
       }
    });
  });
  
});
