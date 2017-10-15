/*
	index.js
	Date: 2015.12.23
	Author: Kevin Ho
	Email: kevin.ho@optimusinfo.com
*/
var currentCarouselSlide = 0;
var timer;

$(function() {

    // Hide unneeded elements based on CMS
    if (carousel_arr.length <= 1) {
        $("#body-carousel .carousel-nav").hide();
    }

    // Arrows for Header Carousel

    $("#body-carousel .car-right").on("click", function() {
         if (currentCarouselSlide+1 < carousel_arr.length) {
             currentCarouselSlide++;
         } else {
             currentCarouselSlide = 0;
         }
         popCarousel(carousel_arr[currentCarouselSlide], "left");
    });

    $("#body-carousel .car-left").on("click", function() {
         if (currentCarouselSlide-1 >= 0) {
             currentCarouselSlide--;
         } else {
             currentCarouselSlide = carousel_arr.length - 1;
         }
         popCarousel(carousel_arr[currentCarouselSlide], "right");
    });

    resetCarouselTimer();

    // Product Solutions Accordion animation
    $(".icon-expand").on("click", function() {
        if ($(this).closest(".accordion-flap").hasClass("active")) {
            // Animations
            $(".accordion-flap").velocity({"width": "33.33%"});
            $(".accordion-flap .content").velocity("stop").velocity({"margin-top": "216px"}, 500);
            $(".accordion-flap .icon-expand").attr("src", img_path + "icon/plus.png");
            $(".accordion-flap table.product-options").velocity("fadeOut", 300);
            $(".accordion-flap .bg-inactive").velocity("stop").velocity("fadeIn", 500);
            $(".accordion-flap .bg-active").velocity("stop").velocity("fadeOut", 500);
            $(".accordion-flap.inactive h5").velocity("stop").velocity("slideDown", 500);

            // Set Active/Inactive Classes
            $(".accordion-flap").removeClass("active").removeClass("inactive");
        } else {
            // Set Active/Inactive Classes
            $(".accordion-flap").removeClass("active").removeClass("inactive");
            $(this).closest(".accordion-flap").addClass("active");
            $(".accordion-flap").not(".active").addClass("inactive");

            // Animations
            $(".accordion-flap.active").velocity({width: "50%"});
            $(".accordion-flap.inactive").velocity({width: "25%"});

            $(".accordion-flap.active .icon-expand").attr("src", img_path + "icon/minus.png");
            $(".accordion-flap.active .content").velocity("stop").velocity({"margin-top": "160px"}, 500);
            $(".accordion-flap.active .bg-inactive").velocity("stop").velocity("fadeOut", 500);
            $(".accordion-flap.active .bg-active").velocity("stop").velocity("fadeIn", 500);
            $(".accordion-flap.active h5:hidden").velocity("stop").velocity("slideDown", 500);
            $(".accordion-flap.active table.product-options").velocity("stop").velocity("fadeIn", 300);

            $(".accordion-flap.inactive .icon-expand").attr("src", img_path + "icon/plus.png");
            $(".accordion-flap.inactive .content").velocity("stop").velocity({"margin-top": "261px"}, 500);
            $(".accordion-flap.inactive .bg-inactive").velocity("stop").velocity("fadeIn", 500);
            $(".accordion-flap.inactive .bg-active").velocity("stop").velocity("fadeOut", 500);
            $(".accordion-flap.inactive h5").velocity("stop").velocity("slideUp", 500);
            $(".accordion-flap.inactive table.product-options").velocity("stop").velocity("fadeOut", 300);
        }
    });
});


/*
 *  HOME CAROUSEL
 */

// Pull data for Home Carousel slides from DB
function ajaxHomeCarousel(pid, direction) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: ajax_url,
        data: {
            'action'     : 'get_home_carousel',
            'post_id'    : pid
        },
        success: function( response ) {
            if ( !response.error ) {
                //console.log(response);
                popCarousel(response, direction);
            } else {
                console.log('error: ' + response.error );
            }
        }
    });
}

function resetCarouselTimer() {
    clearInterval(timer);
    timer = setInterval(function() {
        $("#body-carousel .car-right").trigger("click");
    }, 10000);
}

function popCarousel(data, direction) {
    //console.log(data);
    resetCarouselTimer();

    var element = "#body-carousel";
    var directionIn;
    var directionOut;

    if (direction != null && direction == "right") {
        directionIn = "transition.slideRightIn";
        directionOut = "transition.slideLeftOut";
    } else {
        directionIn = "transition.slideLeftIn";
        directionOut = "transition.slideRightOut";
    }

    $(element + " .carousel-content")
    .velocity(directionOut, 300, function() {
        $(this).find("h4").html(data.heading1);
        $(this).find("h1").html(data.heading2);
        $(this).find("h5").html(data.subheading);
    })
    .velocity(directionIn);

    $(element + " .carousel-text .button")
    .velocity("fadeOut", 300, function() {
        $(this).attr("href", data.buttonurl);
        $(this).html(data.buttontext);
    })
    .velocity("fadeIn", 300);


    delete $(".vidbg-container video");
    $(".vidbg-container video").remove();
    delete $(".vidbg-container");
    $(".vidbg-container").remove();

    $("#body-carousel").css("background-image", "url('" + data.image + "')" );
    
    $('.vidbg-box').vidbg({
        'mp4': data.video_url,
        'poster': data.image,
    }, {
        // options
        muted: true,
        loop: true
    });
}