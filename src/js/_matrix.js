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

    $(".pflCell, .matrix-indicator").hover(function() {
        $(this).parent().addClass("active");
        $('.matrixTable td:nth-child(' + ($(this).index() + 1) + ')').addClass('active');
        $('.matrixTable th:nth-child(' + ($(this).index() + 1) + ')').addClass('active');
    }, function() {
        $('.matrixTable td:nth-child(' + ($(this).index() + 1) + ')').removeClass('active');
        $('.matrixTable th:nth-child(' + ($(this).index() + 1) + ')').removeClass('active');
        $(this).parent().removeClass("active");
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
