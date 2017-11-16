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

    $('.hamburger').click(function() {
        $main_nav.slideToggle();
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