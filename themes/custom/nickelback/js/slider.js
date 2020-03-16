(function ($, Drupal) {

  Drupal.behaviors.houseSlideshow = {
    attach: function (context, settings) {
      var $houseNav = $('.house__nav', context);

      // How many slides should we show within the slide navigation?
      function slideCountToShow() {
        var slideCount = $('> * ', $houseNav).length;
        var maxSlides = 3;
        var slidesToShow = slideCount >= maxSlides ? maxSlides : slideCount;

        // Show up to 5 navigation slides if above ipad widths.
        if (window.matchMedia('(min-width: 768px)').matches) {
          maxSlides = 5;
          slidesToShow = slideCount >= maxSlides ? maxSlides : slideCount;
        }

        return slidesToShow;
      }

      $('.house__for', context).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.house__nav'
      });

      $houseNav.slick({
        arrows: false,
        slidesToShow: slideCountToShow(),
        slidesToScroll: 1,
        asNavFor: '.house__for',
        centerMode: true,
        focusOnSelect: true,
        infinite: false,
        centerMode: false,
      });
    }
  };
})(jQuery, Drupal);