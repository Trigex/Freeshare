$(document).ready(function () {
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active');
        if ($('.row-offcanvas').hasClass('active')) {
            $('[data-toggle="offcanvas"] span').removeClass("glyphicon-menu-right");
            $('[data-toggle="offcanvas"] span').addClass("glyphicon-menu-left");
        } else {
            $('[data-toggle="offcanvas"] span').removeClass("glyphicon-menu-left");
            $('[data-toggle="offcanvas"] span').addClass("glyphicon-menu-right");
        }
    });
});