
$(document).ready(function() {


  // Click on Extra checkout fields

  $('fieldset.fld4 legend, .fld3 label').click(function() {
    $(this).parent().toggleClass('active');
  });

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

    // mark item selected
    var $optionSet = $this.parents('.option-set');
    $optionSet.find('.selected').removeClass('selected');
    $this.addClass('selected');

    // This is for isotope
    //  - store filter value in object
    var group = $optionSet.attr('data-filter-group');
    filters[ group ] = $this.attr('data-filter-value');

    // This is for isotope
    // - convert object into array
    var isoFilters = [];
    for ( var prop in filters ) {
      isoFilters.push( filters[ prop ] )
    }


    // This is for the filter relationship
    //  - collect all selected values for every filter
    var filterValues = ''
    $('#filters select').each(function() {
      var filterName = $(this).attr('data-filter-group');
      var filterValue = $(this).find('.selected').attr('data-filter-value');
      filterValues += filterName + ':' + filterValue + ',';
    });

    // - do the Ajax call
    // - it can be found in anvelocom-functions.php
    var nonce = $('#filters #selects').find('#nonce').attr("value");
    var ajaxurl = $('#filters #selects').find('#ajaxurl').attr("value");

    $.post(
      ajaxurl,
      {
        'action' : 'isotope_filter_ajax',
        'nonce' : nonce,
		'filtered_values': filterValues,
      },
      function(response) {
        removeFilters(response.relations);
      }
    );

    // Do the Isotope filtering
    var selector = isoFilters.join('');
    $container.isotope({ filter: selector });
    return false;
  });


  // Options are removed from selectboxes if they are not in relation with the selected filter
  function removeFilters2(relations) {
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
    });
  }

  function removeFilters(relations) {
    $.each(relations, function(k, v) {
      var values = [];
      $.each(v, function(key, value) {
        values.push(value);
      });

      var select = $('#filters #selects select').eq(k);

      console.log(k+" : "+ values);

      select.children('option').each( function() {
        var value = $(this).attr('data-filter-value');
        value = value.replace('.', '');

        if (values.indexOf(value) != -1) {
          $(this).prop('disabled', false);
        } else {
          $(this).prop('disabled', true);
        }
      });

      // Make 'Toate latimile ...' always active
      select.children('option').first().prop('disabled', false);
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
