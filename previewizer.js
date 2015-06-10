(function($, window, document, undefined) {

  'use strict';

  // jQuery Ready?
  $(function() {

    console.log('Hi There!');

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    function debounce(func, wait, immediate) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    };

    $('body').addClass('folded');

    var button = $('#post-preview');

    $('.previewizer-panel').append('<iframe class="previewizer-frame" name="' + button.attr('target') + '"frameborder="0"></iframe>');

    button.on('click', function(){
      $('.previewizer-panel').show().animate({
        opacity: 1,
        width: '50%'
      }, 500);
      $('#wpwrap').addClass('suppressed').animate({
        width: '50%'
      }, 500);
      $('.previewizer-frame').delay(500).fadeIn(500);
    });

    var myEfficientFn = debounce(function() {
      console.log('refreshing!');
      $('#post-preview').click();
    }, 2000);

    $('#poststuff input').keypress(myEfficientFn);

    $( 'a[id!="post-preview"][href$="preview=true"]' ).on( 'click', function ( e ) {
      e.preventDefault();
      $('#post-preview').click();
    });

    var theName = $( '#post-preview' ).attr( 'target' ) || 'wp-preview';
    $('.previewizer-frame').attr('name', theName);
  });

})(jQuery, window, document);
