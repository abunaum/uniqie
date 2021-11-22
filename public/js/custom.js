
  (function ($) {
  
  "use strict";


    const input = document.getElementById("text_input");
    const btn = document.getElementById("btn");

    btn.addEventListener("click", copyText);

    // CopyText Function
    function copyText() {
      input.select();
      document.execCommand("copy");
      btn.innerHTML = "Copied!";
    }

    $(window).on("resize", ReviewsNavResize);
    $(document).on("ready", ReviewsNavResize);

    // HREF LINKS
    $('a[href*="#"]').click(function (event) {
      if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          event.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top - 74
          }, 1000);
        }
      }
    });

    
  })(window.jQuery);
