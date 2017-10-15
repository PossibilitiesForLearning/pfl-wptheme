$(function() { 
    
    LightBox.init();
        
});


// LightBox Class
(function(window){
    
    'use strict';
    
    var lb_element = "#lb-overlay";
    
    function define_lightbox(){
        var LightBox = {};
        var name = "LightBox";
                
        LightBox.init = function() {
            $(".lightbox").unbind("click");
            $(".lightbox").on("click", function(e) {
                e.preventDefault();

                LightBox.open(
                    $(this).data("lb-format"), 
                    $(this).find(".lb-" + $(this).data("lb-format")).html(),
                    $(this).find(".lb-type").text(),
                    $(this).find(".lb-heading").text(),
                    $(this).find(".lb-description").text()
                );
            });            
        }
        
        LightBox.open = function(format, src, type, heading, description) {   
            console.log(src);
            $.ajax({
                url: template_path + "template/_lightbox-" + format + ".php",
                type: "POST",
                data: {
                    src: src,
                    type: type,            
                    heading: heading,
                    description: description
                },
                success: function(data) {
                    $("body").prepend(data);
                    $("body").addClass("stop-scrolling");

                    $(lb_element).velocity({opacity: 1}, 500);

                    $(lb_element).on("click", function() {                
                        LightBox.close();
                    });
                }
            });
        }
        
        LightBox.close = function() {
            $(lb_element).velocity("fadeOut", 500, function() {        
                $(lb_element).remove();
                $("body").removeClass("stop-scrolling");
            });
        }
        
        return LightBox;
    }
    
    //define globally if it doesn't already exist
    if (typeof(LightBox) === 'undefined') {
        window.LightBox = define_lightbox();
    } else {
        console.log("LightBox already defined.");
    }
})(window);