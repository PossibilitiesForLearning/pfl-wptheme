
$(function() {

    $(".linkout.view-video").click(function (e) {
        e.preventDefault();
        $(".overview-video-thumbnail.lightbox").trigger("click");
    });

    $(".tabs .tab").click(function(e) {
    	$(".tabs .tab").removeClass("active");
    	$(".tab-panel").removeClass("active");

    	$("." + $(this).data("tab")).addClass("active");
    	$(this).addClass("active");
    });

    $("#dealer-region-select").on('change', function(e) {
        $(".region-panel").hide();
        $(".region-panel[data-region='" + $(this).val() + "']").show();
    });

});