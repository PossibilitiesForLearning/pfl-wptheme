/*
	_globals.js
	Date: 2015.01.05
	Author: Kevin Ho
	Email: kevin.ho@optimusinfo.com
*/

var navigationBar = false;
var navigationMenu = "";
var currentTestimonal = 0;
var currentCustomer = 0;
var customersPerPage = 4;
var currentScroll = 0;
var nextScroll = 0;

// Non homepage templates
if (!$("body").hasClass("template-home")) {
    navigationBar = true;
    $("#nav-sticky").show();
}

$(function () {

    navAppear($("#nav-sticky"));

    if (typeof customer_id_arr != 'undefined') {

        getCustomers();

        if (customer_id_arr.length <= 4) {
            $("#body-clients .carousel-arrow").hide();
        }

        if (customer_id_arr.length <= 0) {
            $("#body-clients").hide();
        }
    }

    // Testimonials

    if (typeof testimonial_id_arr != 'undefined') {

        if ($("#body-testimonials").is(":visible")) {
            popTestimonial(testimonial_id_arr[currentTestimonal]);
        }

        if (testimonial_id_arr.length == 1) {
            $("#body-testimonials .car-nav").hide();
        }

        if (testimonial_id_arr.length <= 0) {
            $("#body-testimonials").hide();
        }
    }

    // Submenu hover
    $(".nav-toc td:nth-of-type(3) h5 span").on("mouseover", function () {
        // clear other options
        $(".nav-toc").find("h5").css("color", "#F4F5F4");
        $(".nav-toc").find(".nav-submenu").css("visibility", "hidden");

        // show current option
        $(this).parent().css("color", "#FDB813");
        $(this).parent().find(".nav-submenu").css("visibility", "visible");

        // clear other submenus
        $(".nav-prodmenu").hide();
        // display hovered submenu
        $("#submenu-" + $(this).parent().data("link")).show();
    });

    // Close nav menu
    $(".nav-close-btn").on("click", function () {
        //$("#nav-sticky").velocity("stop").velocity("fadeOut");
        navigationMenu = "";
        navigationBar = false;
        $("#nav-dropdown").velocity("stop").velocity("slideUp");

        $(".nav-backdrop").hide();
    });

    $(".nav-backdrop").on("click", function() {
        $(".nav-close-btn").trigger("click");
    });

    // Click Top Menu
    $(".nav-select").on("click", function () {
        if (!$("#nav-sticky").is(":visible")) {
            navigationBar = true;
            $("#nav-sticky").velocity("stop").velocity("fadeIn");
        }

        if ($("#nav-dropdown").is(":visible") && $(this).data("link") == navigationMenu) {
            navigationMenu = "";
            navigationBar = false;
            $("#nav-dropdown").velocity("stop").velocity("slideUp");
            $(".nav-backdrop").hide();
        } else {
            navigationMenu = $(this).data("link");
            $("#nav-dropdown > .container").hide();
            $("#nav-" + navigationMenu).show();
            navigationBar = true;
            if (!$("#nav-dropdown").is(":visible")) {
                $("#nav-dropdown").velocity("stop").velocity("slideDown");
            }
            $(".nav-backdrop").show();
        }
    });

    // Mobile Menu
    $(".mobile-nav .icon-hamburger, #nav-dropdown-mobile-bg").on("click", function() {
        $("#nav-dropdown-mobile").toggle();
        $("#nav-dropdown-mobile-bg").toggle();
        $("#nav-dropdown-mobile tr.sub-menu").hide();
    });

    $("#nav-dropdown-mobile a.sub-menu-open").on("click", function() {
        $("#nav-dropdown-mobile tr.sub-menu").hide();
        $("#nav-dropdown-mobile tr.sub-menu." + $(this).data("target")).velocity("stop").velocity("transition.slideLeftIn");
    });

    // Navigation Carousel Arrow Hovers
    $(".car-nav").hover(
        function () {
            $(this).find("img").attr("src", $(this).find("img").attr("src").replace(".png", "-active.png"));
        },
        function () {
            $(this).find("img").attr("src", $(this).find("img").attr("src").replace("-active.png", ".png"));
        }
    );

    $(".button.anchor-up").hover(
        function () {
            $(this).find("img").attr("src", $(this).find("img").attr("src").replace(".png", "-active.png"));
        },
        function () {
            $(this).find("img").attr("src", $(this).find("img").attr("src").replace("-active.png", ".png"));
        }
    );


    // Arrows for Testimonials

    $("#body-testimonials .car-right").on("click", function () {
        if (currentTestimonal + 1 < testimonial_id_arr.length) {
            currentTestimonal++;
        } else {
            currentTestimonal = 0;
        }
        popTestimonial(testimonial_id_arr[currentTestimonal], "left");
    });

    $("#body-testimonials .car-left").on("click", function () {
        if (currentTestimonal - 1 >= 0) {
            currentTestimonal--;
        } else {
            currentTestimonal = testimonial_id_arr.length - 1;
        }
        popTestimonial(testimonial_id_arr[currentTestimonal], "right");
    });

    // Arrows for Client Logos

    $("#body-clients .text-right .carousel-arrow").on("click", function() {
        if ((currentCustomer+customersPerPage) < customer_id_arr.length) {
            currentCustomer = currentCustomer + customersPerPage;
         } else {
             currentCustomer = (currentCustomer + customersPerPage) - customer_id_arr.length;
         }
        getCustomers("left");
    });

    $("#body-clients .text-left .carousel-arrow").on("click", function() {
        if ((currentCustomer-customersPerPage) >= 0) {
            currentCustomer = currentCustomer - customersPerPage;
         } else {
             currentCustomer = customer_id_arr.length + (currentCustomer - customersPerPage);
         }
        getCustomers("right");
    });

    // Linkout image hovers

    $(".linkout").hover(function() {
        $(this).find("img").attr("src", $(this).find("img").attr("src").replace(".png", "-active.png"));
    }, function() {
        $(this).find("img").attr("src", $(this).find("img").attr("src").replace("-active.png", ".png"));
    });
});

$(window).scroll(function (e) {
    nextScroll = document.body.scrollTop;

    navAppear($("#nav-sticky"));

    currentScroll = nextScroll;
});

// Appearance of the static nav on scroll down
function navAppear(navElement) {
    // Home Page 
    if ($("body").hasClass("template-home")) {
        if ((document.body.scrollTop > 20) && (nextScroll < currentScroll)) {
            if (!navElement.is(":visible")) {
                navElement.velocity("stop").velocity("fadeIn");
            }
        } else {
            if (navElement.is(":visible") && !navigationBar) {
                navElement.velocity("stop").velocity("fadeOut");
            }
        }
    } else {
        // Side Pages
        if (document.body.scrollTop < 140) {
            if (!navElement.is(":visible")) {
                navElement.velocity("stop").velocity("fadeIn",50);
            }
        } else if ((document.body.scrollTop > 140) && (nextScroll > currentScroll)) {
            if (navElement.is(":visible")) {
                navElement.velocity("stop").velocity("fadeOut");
            }
        } else if (nextScroll < currentScroll) {
            if (!navElement.is(":visible")) {
                navElement.velocity("stop").velocity("fadeIn");
            }
        }
    }
}

/*
 *  TESTIMONIALS
 */

// Populate a new testimonial on the page
function popTestimonial(data, direction) {

    var element = "#body-testimonials";
    var directionIn;
    var directionOut;

    if (direction != null && direction == "right") {
        directionIn = "transition.slideRightIn";
        directionOut = "transition.slideLeftOut";
    } else {
        directionIn = "transition.slideLeftIn";
        directionOut = "transition.slideRightOut";
    }

    $(element + " h5")
        .velocity(directionOut, 300, function () {
            $(this).html('"' + data.content + '"');
        })
        .velocity(directionIn);

    $(element + " h6")
        .velocity(directionOut, 300, function () {
            $(this).html(data.client);
        })
        .velocity(directionIn);

    $(element + " .logo-client")
        .velocity(directionOut, 300, function () {
            $(this).attr("src", data.logo).attr("alt", data.title);
        })
        .velocity(directionIn);

    $(element + " .linkout").hide();
    if (data.case_study != null && data.case_study.trim().length > 0) {
        $(element + " .linkout").attr("href", data.case_study).show();
    }
}

/*
 *  CUSTOMERS
 */

function getCustomers(direction) {
    for (i = 0; i < customersPerPage; i++) {
        if (customer_id_arr[currentCustomer + i] != null) {
            popCustomer(customer_id_arr[currentCustomer + i], direction, i+1);
        } else {
            popCustomer(customer_id_arr[currentCustomer + i - customer_id_arr.length], direction, i+1);
        }
    }
}

// Populate a new Customer on the page
function popCustomer(data, direction, position) {
    var element = "#body-clients .logo-box:nth-child(" + position + ")";
    var directionIn;
    var directionOut;

    if (direction != null && direction == "right") {
        directionIn = "transition.slideRightIn";
        directionOut = "transition.slideLeftOut";
    } else {
        directionIn = "transition.slideLeftIn";
        directionOut = "transition.slideRightOut";
    }

    $(element)
    .velocity(directionOut, 300, function() {
        $(element + " img").attr("src", data.logo);
        $(element + " img").attr("title", data.name);
    })
    .velocity(directionIn);

    $(element + " a").attr("href", data.url);
}

// ACTIVITY INDICATOR

var activityIndicatorOn = function () {
    $('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
},
activityIndicatorOff = function () {
    $('#imagelightbox-loading').remove();
},

// OVERLAY

overlayOn = function () {
    $('<div id="imagelightbox-overlay"></div>').appendTo('body');
},
overlayOff = function () {
    $('#imagelightbox-overlay').remove();
},

// CLOSE BUTTON

closeButtonOn = function (instance) {
    $('<button type="button" id="imagelightbox-close" title="Close"></button>').appendTo('body').on('click touchend', function () {
        $(this).remove();
        instance.quitImageLightbox();
        return false;
    });
},
closeButtonOff = function () {
    $('#imagelightbox-close').remove();
};
