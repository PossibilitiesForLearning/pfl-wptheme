/*
    validator.js
	Date: 2015.01.17
	Author: Kevin Ho
	Email: kevin.ho@optimusinfo.com
    Description: Library to validate form fields
*/

(function(window){

    'use strict';

    function define_validator(){
        var Validator = {};
        var name = "Validator";

        Validator.greet = function(){
            console.log("Test from the " + name + " library.");
        }

        // Universal validation function
        // element: DOM element
        // testArr: JSON pairing of validation to test and the function values (array)

        Validator.test = function(element, testArr) {

            var valid = true;

            for (var i = 0; i < Object.keys(testArr).length; i++) {
                switch(Object.keys(testArr)[i]) {
                    case "requiredInput":
                        valid = this.requiredInput(element, testArr[Object.keys(testArr)[i]][0]);
                        break;
                    case "requiredSelect":
                        valid = this.requiredSelect(element, testArr[Object.keys(testArr)[i]][0]);
                        break;
                    case "emailInput":
                        valid = this.emailInput(element);
                        break;
                    case "phoneInput":
                        valid = this.phoneInput(element);
                        break;
                    case "textArea":
                        valid = this.textArea(element);
                        break;
                    default:
                        valid = false;
                        break;
                }
            }

            //Debug
            //console.log("Validator: " + element.attr('id') + " : " + valid);

            // Adds a class called invalidField to input, styles defined in CSS
            if (valid) {
                element.removeClass("invalidField");
            } else {
                element.addClass("invalidField");
            }

            return valid;
        }

        // Validate Input/Textarea Fields
        Validator.requiredInput = function(inputField, minLength) {
            if (minLength == null) minLength = 1;
            return (inputField.val().trim().length >= minLength);
        }

        // Validate Select Fields
        Validator.requiredSelect = function(selectField, defaultValue) {
            if (defaultValue == null) defaultValue = "";
            return (selectField.val().trim() != defaultValue );
        }

        // Validate Email Input Fields
        Validator.emailInput = function(inputField) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return (filter.test(inputField.val().trim()));
        }

        // Validate International Phone Input Fields
        Validator.phoneInput = function(inputField) {
            //var filter = /^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([1-9]1[01-9]|[1-9][01-8]1|[1-9][01-8][01-9])\s*\)|([1-9]1[01-9]|[1-9][01-8]1|[1-9][01-8][01-9]))\s*(?:[.-]\s*)?)?([1-9]1[01-9]|[1-9][01-9]1|[1-9][01-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/;
            var filter = /^[0-1]?\d{7,16}$/; 
            var input = inputField.val().trim().replace(/-/g,"").replace(/\./g,"").replace(/ /g,"");
            //var filter = /^((\(\d{3}\)?)|(\d{3})?)([\s-./]?)(\d{3,4})([\s-./]?)(\d{4})$/;
            return (filter.test(input));
        }
        
        Validator.textArea = function(textArea, minLength) {
            if (minLength == null) minLength = 1;            
            return (textArea.val().trim().length >= minLength);
        }

        // Loop through boolean validation array
        // Return false if any field is invalid
        Validator.validateArray = function(arr) {
            var valid = true;
            $.each(arr, function(i, boolVal) {
                if (!boolVal) {
                    valid = false;
                }
            });
            return valid;
        }

        return Validator;
    }

    //define globally if it doesn't already exist
    if (typeof(Validator) === 'undefined') {
        window.Validator = define_validator();
    } else {
        console.log("Validator already defined.");
    }
})(window);
