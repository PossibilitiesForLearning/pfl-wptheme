$( document ).ready(function() {
    console.log( "matrix ready!" );
    var infoTipTimer;

    // title hover tooltip functions
    $(".infotip-mouseover").hover(function() {
        clearInterval(infoTipTimer);
        $(".container-infotip").fadeIn();
    }, function() {
        infoTipTimer = setInterval(function() {
             $(".container-infotip").fadeOut();
        }, 3000);
    });

    $(".pflRow").hover(function() {
        $(this).addClass("active");
    }, function() {
        $(this).removeClass("active");
    });

    $(".matrix-indicator").click(function () {
        $(this).find(".checkbox-indicator").click();
    });

    $(".checkbox-indicator").change(function() {
        if ($(this).prop("checked")) {
            $(this).parent().parent().addClass("selected");
        } else {
            $(this).parent().parent().removeClass("selected");
        }
    });
});
