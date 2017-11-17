$(document).ready(function(){
    var $color = $('li[title="active"]').css('background-color');
    var $html = $('html');
    $html.css("--colorMain", $color);

    $(window).scroll(function() {
        var $scrolled = window.pageYOffset || document.documentElement.scrollTop;
        var $header_top = $('.header_top');
        if ($scrolled > parseInt($header_top.css('height'))) {
            $header_top.css('position', 'fixed');
        } else {
            $header_top.css('position', 'static');
        }
    });

    var $main_nav = $('.main_nav');
    var $nav_btn = $('.hamburger');
    var $deg, k;

    $nav_btn.click(function() {
        $main_nav.slideToggle();

        k++;
        if (k === 1) {
            $deg = 0;
        } else {
            $deg = 180;
            k = 0;
        }

        $nav_btn.animate({deg: $deg}, {duration: 500, step: function (now) {
           $('.hamburger img').css({
               transform: 'rotate(' + now + 'deg)'
           });
        }
        })();
    });

    $(window).resize(function () {
        if ($main_nav.css('display') == 'none' && parseInt($html.css('width')) >= 751) {
            $('.main_nav').css('display', 'flex');
        }
        if (parseInt($html.css('width')) <= 751) {
            $('.main_nav').css('display', 'none');
        }
    });
});
