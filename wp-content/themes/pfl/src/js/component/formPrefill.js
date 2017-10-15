var urlVars = getUrlVars();
setFormValues();

function setFormValues() {
    matchInputValue("inq_CampaignID", "campaignID");
    matchInputValue("inq_City", "city");
    matchInputValue("inq_Company", "company");
    matchInputValue("inq_Email", "email");
    matchInputValue("inq_FirstName", "first");
    matchInputValue("inq_LastName", "last");
    matchInputValue("lead_source_", "source");
    matchInputValue("inq_Telephone", "phone");
    matchInputValue("Topic_", "topic");
    matchDropdownValue("inq_Country", "country");
    matchDropdownValue("inq_StateProvince", "state");
    matchDropdownValue("Role_Job_Function", "jobtitle");
    matchDropdownValue("Industry", "industry");
    matchCheckboxValue("product", "product");
}

function getUrlVars() {
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

function getQueryVar (field) {
    var ret = urlVars[field];
    if (typeof ret != 'undefined') {
        return decodeURI(ret);
    } else {
        return "";
    }
}

function matchInputValue(inputName, value) {    
    if (checkExist(inputName, value)) {
        document.getElementsByName(inputName)[0].value = getQueryVar(value);
    }
}

function matchDropdownValue(selectBox, value) {    
    if (checkExist(selectBox, value)) {
        var field = document.getElementsByName(selectBox)[0];
        for (var i=0; i < field.options.length; i++ ) {
            if (field.options[i].text.toLowerCase() == getQueryVar(value).toLowerCase()) {                
                field.options[i].selected = true;
                return;
            }
        }
    }
}

function matchCheckboxValue(checkboxName, value) {
    if (checkExist(checkboxName, value)) {       
        var checkboxes = document.getElementsByName(checkboxName);
        for (var i=0; i < checkboxes.length; i++) {
            if (checkboxes[i].value.toLowerCase() == getQueryVar(value).toLowerCase()) {                
                checkboxes[i].checked = true;
                return;
            }
        }
    }
}

function checkExist(field, queryvar) {
    if (document.getElementsByName(field).length > 0 && getQueryVar(queryvar).length > 0) {
        return true;
    } else {
        return false;
    } 
}