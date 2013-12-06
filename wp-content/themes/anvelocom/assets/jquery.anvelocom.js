
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
    
    // convert object into array
    var isoFilters = [];
    for ( var prop in filters ) {
      isoFilters.push( filters[ prop ] )
    }
    
    // Do the Ajax call to show only related filters
    // - this goes through the Anvelocom plugin
    var nonce = $('#filters #selects').find('#nonce').attr("value");
    var ajaxurl = $('#filters #selects').find('#ajaxurl').attr("value");
    var value = $this.attr('data-filter-value');
    value = value.replace('.', '');
    $.post(
      ajaxurl, 
      {
        'action' : 'isotope_filter_ajax',
        'nonce' : nonce,
        'filter' : group,
        'filter_value' : value
      }, 
      function(response) {        
        alert(response.relations);    
      }
    );
    
    
    // Do the Isotope filtering
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
