$(document).ready(function(){
    var $color = $('li[title="active"]').css('background-color');
    var $html = $('html');
    $html.css("--colorMain", $color);

    $(window).scroll(function() {
        var $scrolled = window.pageYOffset || document.documentElement.scrollTop;
        var $header_top = $('.header_top');

        if ($scrolled > parseInt($('header').css('height'))) {
            $header_top.css({
                'position': 'fixed',
                'margin-bottom' : 0
            });
            $('main').css('margin-top', '40px')
        } else {
            $header_top.css({
                'position': 'static',
                'margin-bottom' : '40px'
            });
            $('main').css('margin-top', '0')
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
        if ($main_nav.css('display') == 'none' && parseInt($html.css('width')) >= 414) {
            $('.main_nav').css('display', 'flex');
        }
        if (parseInt($html.css('width')) <= 414) {
            $('.main_nav').css('display', 'none');
        }
    });
});
