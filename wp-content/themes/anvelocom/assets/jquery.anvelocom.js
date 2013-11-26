
$(document).ready(function() {

  // Hide / reveal menu on mobiles
  $('#header nav').click(function() {
    $('#header nav ul').slideToggle('slow'); 
    $(this).toggleClass('active'); 
  });

  // Scroll to top
  $('#footer nav').click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false; 
  });

  
  // Filter Team members
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
    
    // convert object into array
    var isoFilters = [];
    for ( var prop in filters ) {
      isoFilters.push( filters[ prop ] )
    }
    
    var selector = isoFilters.join('');
    $container.isotope({ filter: selector });
    return false;
  });

  
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
