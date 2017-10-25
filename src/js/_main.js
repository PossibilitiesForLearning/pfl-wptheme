$( document ).ready(function() {
    console.log( "ready!" );

    
    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();

    $(document).scroll(function() {
        var newOpacity = 0.8 - (0.8 * ($(document).scrollTop() / $(window).height()));
        $("#image-background").css("opacity", newOpacity);
        $(".color-block.block2").css("opacity", 1- newOpacity);
        didScroll = true;
    });

    $(".navbar-items li").click(function() {
        $(".navbar-items li").removeClass("active");
        $(this).addClass("active");
        $("#nav-menu-mast").toggle(400);
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();
        
        // Make sure they scroll more than delta
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
        
        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight){
            // Scroll Down
            $('.navbar').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                $('.navbar').removeClass('nav-up').addClass('nav-down');
            }
        }
        
        lastScrollTop = st;
    }
});