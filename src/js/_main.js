$(document).ready(function () {
    console.log("ready!");

    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();

    var navStructure;
    var activeNavTree;

    $.getJSON("/wp-content/themes/pfl/_navStructure.json", function (data) {
        navStructure = data;
        console.log(navStructure);
    });

    $(document).scroll(function () {
        var newOpacity = 0.8 - (0.8 * ($(document).scrollTop() / $(window).height()));
        $("#image-background").css("opacity", newOpacity);
        $(".color-block.block2").css("opacity", 1 - newOpacity);
        didScroll = true;
    });

    $(".navbar-items li").click(function (e) {
        if ($(this).hasClass("navLink")) {
            // If no menu items, treat it as a link
            window.location.href = $(this).find("a").first().attr("href");
        } else if ($(this).hasClass("search") && $(this).hasClass("active")) {            
            $("#nav-menu-search").slideToggle(500);
            $(".navbar-items li").removeClass("active");
        } else if ($(this).hasClass("search")) {   
            if ($(".navbar-items li").hasClass("active")) {                
                $("#nav-menu-mast").slideToggle(500);
                $(".navbar-items li").removeClass("active");
            }       
            $("#nav-menu-search").slideToggle(500);
            $(this).addClass("active");
        } else if ($(this).hasClass("active")) {
            // If already open, close the menu back down
            $("#nav-menu-mast").slideToggle(500);
            $(".navbar-items li").removeClass("active");
        } else {
            if ($(".navbar-items li.search").hasClass("active")) {      
                $("#nav-menu-search").slideToggle(500);
                $(".navbar-items li").removeClass("active");
            }

            $(".navbar-items li").removeClass("active");
            $(this).addClass("active");
            navItemFill($(this).text());

            // if menu is not open yet
            if (!$("#nav-menu-mast").is(":visible")) {
                $("#nav-menu-mast").slideToggle(500);
            }
        }
    });

    function navItemFill(menuHeading) {
        activeNavTree = navStructure[menuHeading];
        console.log(activeNavTree);

        $("#navMenu-Tier2").empty();
        $("#navMenu-Tier3").empty();

        $.each(activeNavTree, function(k,v) {
            $("#navMenu-Tier2").append("<li data-key='" + k + "'><a href='/?page_id=" + v.URL + "'>" + k + "</a><img class='arrow' src='/wp-content/themes/pfl/images/navArrow.png'/></li>");
        });

        $("#navMenu-Tier2 li").mouseover(function () {
            var subMenuTree = activeNavTree[$(this).data("key")].Menu;

            
            $("#navMenu-Tier3").empty();
            
            $.each(subMenuTree, function(k,v) {
                $("#navMenu-Tier3").append("<li data-key='" + k + "'><a href='/?page_id=" + v + "'>" + k + "</a></li>");
            });
        });
    }

    setInterval(function () {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('.navbar').removeClass('nav-down').addClass('nav-up');
            $("#nav-menu-mast").fadeOut(100);
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('.navbar').removeClass('nav-up').addClass('nav-down');
            }
        }

        lastScrollTop = st;
    }
});