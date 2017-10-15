/*
	products.js
	Date: 2015.01.17
	Author: Kevin Ho
	Email: kevin.ho@optimusinfo.com
*/

$(function() {

    initThumbnailInteractions();

    // Product Overview Page
    $(".overview-video-thumbnail").hover(function() {
        $(this).find(".video-playicon").velocity({opacity: 0.4}, 250);
    }, function() {
        $(this).find(".video-playicon").velocity({opacity: 1}, 250);
    });

    $(".linkout.view-video").click(function (e) {
        e.preventDefault();
        $(".overview-video-thumbnail.lightbox").trigger("click");
    });

    // Product Features Page
    if (typeof feature_product_id != 'undefined') {
        parseFeaturesRow();
    }
    initFeaturesSelect();
    initComparisonTabs();
    hilightCompareTables();

    if (typeof vehicle_templates != 'undefined') {     
        filterLibraryCategory();
        filterLibraryTemplate();
    }

    $("#select-library-category").on("change", function () {
        filterLibraryTemplate();
    });

    $("#select-library-template").on("change", function() {
        selectLibraryTemplate();
    });
});

/*
 *  FEATURES ROW
 */

function initFeaturesSelect() {
    $("#feature-dropdown").on("change", function() {
        parseFeaturesRow();
    });
}

function parseFeaturesRow() {
    var taxonomy_id = $("#feature-dropdown").val();
    var selected_features = [];

    $.each(features, function(key, feature) {
        $.each(feature["taxonomy"], function(key, taxonomy) {
            if (taxonomy[0] == taxonomy_id) {
                selected_features.push(feature);
                return;
            };
        });
    });
    popFeaturesRow(selected_features);
}

function popFeaturesRow(response) {
    $("#page-features-rows").empty();

    $.each(response, function(key, value) {
        var format = "screenshot";
        if (safeField(value["meta"]["wpcf-full-video"]) != "") format = "video";

        $.ajax({
            url: template_path + "template/_product-feature-row.php",
            type: "post",
            data: {
                full_image: safeField(value["meta"]["wpcf-full-image"]),
                full_video:  safeField(value["meta"]["wpcf-full-video"]),
                type: $("#feature-dropdown option:selected").text(),
                heading: safeField(value["meta"]["wpcf-heading"]),
                description: safeField(value["meta"]["wpcf-description"]),
                description_full: safeField(value["meta"]["wpcf-description-full"]),
                thumb: safeField(value["meta"]["wpcf-image-thumbnail"]),
                format: format,
            },
            success: function(data) {
                $("#page-features-rows").append(data);
                LightBox.init();
                initThumbnailInteractions();
            }
        });
    });
}

function initThumbnailInteractions() {
    $('.thumb').unbind('mouseenter mouseleave');

    // Thumbnails
    $(".feature-row .thumb").hover(function () {
        $(this).find(".plus-icon").attr("src", $(this).find(".plus-icon").attr("src").replace(".png", "-active.png"));
        $(this).find(".thumb-image").velocity("stop").velocity({
            opacity: 0.8
        });
        $(this).find(".video-playicon").velocity("stop").velocity({opacity: 0.4}, 250);
    }, function () {
        $(this).find(".plus-icon").attr("src", $(this).find(".plus-icon").attr("src").replace("-active.png", ".png"));
        $(this).find(".thumb-image").velocity("stop").velocity({
            opacity: 1
        });
        $(this).find(".video-playicon").velocity("stop").velocity({opacity: 1}, 250);
    });
}

function initComparisonTabs() {
    $(".comparison-tab").click(function() {
        $(".comparison-tab").removeClass("active");
        $(this).addClass("active");
        var active = $(this).data("compare");
        $(".container.grid:visible").velocity("stop").velocity("transition.flipXOut", 300, function() {
        });
        $(".container.grid." + active).velocity("stop").velocity("transition.flipXIn").removeClass("hidden");
    })
}

function hilightCompareTables() {
    $("#page-comparison-grid tbody td").hover(function() {
        $(this).parent().find("td").addClass("lowlight");
    }, function() {
        $(this).parent().find("td").removeClass("lowlight");
    });
}

function filterLibraryCategory() {
    var categories = [];
    for (var i = 0; i < vehicle_templates.length; i++) {
        if (jQuery.inArray(vehicle_templates[i].category, categories) < 0) {
            categories.push(vehicle_templates[i].category);
            $("#select-library-category").append("<option value='" + vehicle_templates[i].category + "'>" + vehicle_templates[i].category + "</option>");
        }
    }
}

function filterLibraryTemplate() {
    $("#select-library-template").empty();
    var category = $("#select-library-category").val();
    
    var options = [];
    $("#select-library-template").append("<option value=''>Select...</option>");

    for (var i = 0; i < vehicle_templates.length; i++) {
        if (vehicle_templates[i].category == category) {    
            $("#select-library-template").append("<option value='" + vehicle_templates[i].id + "'>" + vehicle_templates[i].name + "</option>");
        }
    }
}

function selectLibraryTemplate() {
    if ($("#select-library-template").val() != "") {
        $(".product-select").hide();    
        $("#" + $("#select-library-template").val()).fadeIn();
    }
}

function safeField(field) {
    if (field == null || field == 'undefined') {
        return "";
    } else {
        return field[0];
    }
}

