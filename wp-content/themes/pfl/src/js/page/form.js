/*
	form.js
	Date: 2015.01.17
	Author: Kevin Ho
	Email: kevin.ho@optimusinfo.com
*/

$(function() {
    var show = getUrlVars()["show"];

    if (typeof show == 'undefined') {
        $("[id='formMessage']").show();
        $("[id='thankYouMessage']").hide();
        $("[id='errorMessage']").hide();
    } else if (show == 'error') {
        $("[id='formMessage']").hide();
        $("[id='thankYouMessage']").hide();
        $("[id='errorMessage']").show();
        $("[id='errorMessage'] h5").append("<p>" + parseQueryVar("errorMessage") +  "</p>" );
        
    } else if (show == 'success') {
        $("[id='formMessage']").hide();
        $("[id='thankYouMessage']").show();
        $("[id='errorMessage']").hide();
    } else {
        $("[id='formMessage']").show();
        $("[id='thankYouMessage']").hide();
        $("[id='errorMessage']").hide();
    }

    // Validate forms
    if ($("#clickdimensionsForm").hasClass("productInquiry")) {        
        validateProductInquiry(".pageForm.productInquiry");
    } else if ($("#clickdimensionsForm").hasClass("freeTrial")) {
        validateFreeTrial(".pageForm.freeTrial");
    } else if ($("#clickdimensionsForm").hasClass("contactSales")) {
        validateContactSales(".pageForm.contactSales");
    }

    if (cookie_data != null && cookie_data != 'undefined') {
        setCookieValues(cookie_data);
    }

    $("#software-update-product").on("change", function() {
        var product = $(this).val();
        var versions = [];

        $("#software-update-version").find('option').remove();        

        if (product.length > 0) {

            $("#software-update-next").show();

            $.each(softwareUpdates, function(key, value) {
                if (value.product_name == product) {
                    versions.push(value);
                }
            });

            versions.sort(function(a,b) {
                return compareString(a.version, b.version);
            });

            $.each(versions, function(key, value) {             
                $("#software-update-version").append($("<option>",
                {
                    value       : value.guid,
                    text        : value.version
                }));
            });

        } else {
            $("#software-update-next").hide();
        }
    });

    $("#software-update-next").on("click", function() {
        window.location = $("#software-update-version").val().replace("#038;", "");
    });

    // Blog Category Dropdown
    $("form.blog-category select").on("change", function () {
        if ($(this).val() != "-1") {
            $(this).parent().submit();
        };
    });

});

function validateProductInquiry(formElt) {
    $(formElt + " input,  " + formElt + " select, " + formElt + " textarea").on("change keyup", function() {
        
        if ($(formElt + " .formfield.country").val() == "U.S.") {
            $(formElt + " .formfield.state").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        } else if ($(formElt + " .formfield.country").val() == "Canada") {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
            $(formElt + " .formfield.province").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
        } else {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        }
        
        var valid = [];
        
        valid.push(Validator.test($(formElt + " .formfield.firstname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.lastname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.emailaddress"), {"requiredInput" : [1], "emailInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.companyname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.telephone"), {"requiredInput" : [1], "phoneInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.country"), {"requiredSelect" : ["-1"]}));        
        valid.push(Validator.test($(formElt + " .formfield.role"), {"requiredSelect" : ["-1"]}));        
        valid.push(Validator.test($(formElt + " .formfield.industry"), {"requiredSelect" : ["-1"]}));
        //valid.push(Validator.test($(formElt + " .formfield.comments"), {"requiredInput" : [1]}));
        
        if ($(formElt + " .formfield.province").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.province"), {"requiredSelect" : ["-1"]}));
        }
        if ($(formElt + " .formfield.state").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.state"), {"requiredSelect" : ["-1"]}));
        }

        if (Validator.validateArray(valid)) {
            $(formElt + " .button").removeAttr("disabled");
            $(formElt + " .validationMessage h5").css("visibility", "hidden");
        } else {
            $(formElt + " .button").attr("disabled", "disabled");
            $(formElt + " .validationMessage h5").css("visibility", "visible");
        }        
        
    });    
}

function validateFreeTrial(formElt) {
    $(formElt + " input,  " + formElt + " select, " + formElt + " textarea").on("change keyup", function() {

        if ($(formElt + " .formfield.country").val() == "U.S.") {
            $(formElt + " .formfield.state").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        } else if ($(formElt + " .formfield.country").val() == "Canada") {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
            $(formElt + " .formfield.province").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
        } else {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        }

        var valid = [];

        valid.push(Validator.test($(formElt + " .formfield.firstname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.lastname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.emailaddress"), {"requiredInput" : [1], "emailInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.companyname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.telephone"), {"requiredInput" : [1], "phoneInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.country"), {"requiredSelect" : ["-1"]}));
        if ($(formElt + " .formfield.province").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.province"), {"requiredSelect" : ["-1"]}));
        }
        if ($(formElt + " .formfield.state").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.state"), {"requiredSelect" : ["-1"]}));
        }

        if (Validator.validateArray(valid)) {
            $(formElt + " .button").removeAttr("disabled");
            $(formElt + " .validationMessage h5").css("visibility", "hidden");
        } else {
            $(formElt + " .button").attr("disabled", "disabled");
            $(formElt + " .validationMessage h5").css("visibility", "visible");
        }

    });
}

function validateContactSales(formElt) {
    $(formElt + " input,  " + formElt + " select, " + formElt + " textarea").on("change keyup", function() {
        
        if ($(formElt + " .formfield.country").val() == "U.S.") {
            $(formElt + " .formfield.state").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        } else if ($(formElt + " .formfield.country").val() == "Canada") {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
            $(formElt + " .formfield.province").show().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
        } else {
            $(formElt + " .formfield.state").hide().attr("id","inq_StateProvince").attr("name","inq_StateProvince");
            $(formElt + " .formfield.province").hide().attr("id","inq_StateProvince_disabled").attr("name","inq_StateProvince_disabled");
        }
        
        var valid = [];
        
        valid.push(Validator.test($(formElt + " .formfield.firstname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.lastname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.emailaddress"), {"requiredInput" : [1], "emailInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.companyname"), {"requiredInput" : [1]}));
        valid.push(Validator.test($(formElt + " .formfield.telephone"), {"requiredInput" : [1], "phoneInput": []}));
        valid.push(Validator.test($(formElt + " .formfield.country"), {"requiredSelect" : ["-1"]}));        
        valid.push(Validator.test($(formElt + " .formfield.role"), {"requiredSelect" : ["-1"]}));        
        valid.push(Validator.test($(formElt + " .formfield.industry"), {"requiredSelect" : ["-1"]}));
        //valid.push(Validator.test($(formElt + " .formfield.comments"), {"requiredInput" : [1]}));
        
        if ($(formElt + " .formfield.province").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.province"), {"requiredSelect" : ["-1"]}));
        }
        if ($(formElt + " .formfield.state").is(":visible")) {
            valid.push(Validator.test($(formElt + " .formfield.state"), {"requiredSelect" : ["-1"]}));
        }

        if (Validator.validateArray(valid)) {
            $(formElt + " .button").removeAttr("disabled");
            $(formElt + " .validationMessage h5").css("visibility", "hidden");
        } else {
            $(formElt + " .button").attr("disabled", "disabled");
            $(formElt + " .validationMessage h5").css("visibility", "visible");
        }        
        
    });    
}

function setCookieValues(cookie) {
    $("#lead_source_").val(cookie.source);
    $("#inq_CampaignID").val(cookie.campaignID);
    $("#inq_FirstName").val(cookie.first);
    $("#inq_LastName").val(cookie.last);
    $("#inq_Email").val(cookie.email);
    $("#inq_Company").val(cookie.company);
    $("#inq_Telephone").val(cookie.phone);

    matchDropdownValue("#inq_Country", cookie.country);
    matchDropdownValue("#inq_StateProvince", cookie.state);
    matchDropdownValue("#Role_Job_Function", cookie.jobtitle);
    matchDropdownValue("#Industry", cookie.industry);
    matchCheckboxValue("product", cookie.product);
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function parseQueryVar (field) {
    var ret = getUrlVars()[field];
    if (typeof ret != 'undefined') {
        return decodeURI(ret);
    } else {
        return "";
    }
}

function matchDropdownValue(selectBox, value) {
    $(selectBox + " > option").each(function() {
        if (this.value.toLowerCase() == value.toLowerCase()) {
            this.setAttribute("selected", "selected");
            return false;
        }
    });
}

function matchCheckboxValue(checkboxName, value) {
    $("input[type='checkbox'][name='" + checkboxName + "']").each(function() {
        if (this.value.toLowerCase() == value.toLowerCase()) {
            this.setAttribute("checked", true);
            return false;
        }        
    });
}

function compareString(a,b) {
    a = a.toLowerCase();
    b = b.toLowerCase();

    return (a < b) ? -1 : (a > b) ? 1 : 0;
}

function formBackup(source) {
    /* 
    $.ajax({
        type: "POST",
        url: "/form-routing",
        data: {
            "data" : JSON.stringify(queryStringToJSON($("form").serialize())),
            "source" : (source ? source : "")            
        },
        success: function( data, textStatus, jQxhr ){
        },
        dataType: "text"
    });*/
}

var queryStringToJSON = function (url) {
    if (url === '')
        return '';
    var pairs = (url || location.search).slice(1).split('&');
    var result = {};
    for (var idx in pairs) {
        var pair = pairs[idx].split('=');
        if (!!pair[0])
            result[pair[0].toLowerCase()] = decodeURIComponent(pair[1] || '');
    }
    return result;
}