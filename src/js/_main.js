$( document ).ready(function() {
    console.log( "ready!" );

    $(document).scroll(function() {
        var newOpacity = 0.8 - (0.8 * ($(document).scrollTop() / $(window).height()));
        $("#image-background").css("opacity", newOpacity);
        $(".color-block.block2").css("opacicty", 1- newOpacity);
    });

    $(".navbar-items li").click(function() {
        $(".navbar-items li").removeClass("active");
        $(this).addClass("active");
        $("#nav-menu-mast").toggle(400);
    });
});