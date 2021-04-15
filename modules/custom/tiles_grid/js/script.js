(function ($, Drupal, drupalSettings) {
    'use strict';
      Drupal.behaviors.tiles_grid = {
        attach: function (context, settings) {
// init Isotope
var $grid = $('.grid').isotope({
  // options
});
// filter items on button click
$('.filter-button-group').on( 'click', 'button', function() {
  var filterValue = $(this).attr('data-filter');
  $grid.isotope({ filter: filterValue });
});        
        }
      };
    })(jQuery, Drupal, drupalSettings);
    