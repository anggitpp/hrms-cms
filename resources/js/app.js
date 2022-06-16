require('./bootstrap');

window.moment = require('moment');

window.setNumber = function (elem) {
    replace = elem.value.replace(/[\\A-Za-z!"?$%^&*_={};.\:'/@#~,?\<>?|`?\]\[]/g, '');
    elem.value = replace;
}

window.setCurrency = function (elem) {
    replace = window.formatCurrency(elem.value.replace(/[\\A-Za-z!"?$%^&*+_={}; ()\-\:'/@#~,?\<>?|`?\]\[]/g, ''));
    if (replace.length == 0) replace = 0;
    elem.value = replace;
}

window.setNoSpacing = function (elem) {
    replace = elem.value.replace(/ /g, "");
    elem.value = replace;
}

window.formatCurrency = function (val) {
    x = val.split(".");
    num = x[0];

    if (num < 0) return "";
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));

    if (x.length == 1)
        return (((sign) ? '' : '-') + num);
    else
        return (((sign) ? '' : '-') + num + "." + x[1].substr(0, 4));
}

window.getSub = function getSub(value, child, route) {
    route = route == undefined ? 'subMasters' : route;
    var pathArray = window.location.pathname.split( '/' );
    var parentId = value;
    if (parentId) {
        $.ajax({
            url: '/' + [pathArray[1], pathArray[2], route, parentId].join('/'),
            type: "GET",
            dataType: "json",
            success: function (data) {
                var firstOption = $('select[name='+child+']').find("option:first-child").text();
                $('select[name='+child+']').empty();
                $('select[name='+child+']').append('<option value=""> '+ firstOption + '</option>');
                $.each(data, function (key, value) {
                    $('select[name='+child+']').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    } else {
        $('select[name='+child+']').empty();
    }
}

window.modelMatcher = function modelMatcher (params, data) {
    data.parentText = data.parentText || "";

    // Always return the object if there is nothing to compare
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do a recursive check for options with children
    if (data.children && data.children.length > 0) {
        // Clone the data object if there are children
        // This is required as we modify the object to remove any non-matches
        var match = $.extend(true, {}, data);

        // Check each child of the option
        for (var c = data.children.length - 1; c >= 0; c--) {
            var child = data.children[c];
            child.parentText += data.parentText + " " + data.text;

            var matches = modelMatcher(params, child);

            // If there wasn't a match, remove the object in the array
            if (matches == null) {
                match.children.splice(c, 1);
            }
        }

        // If any children matched, return the new object
        if (match.children.length > 0) {
            return match;
        }

        // If there were no matching children, check just the plain object
        return modelMatcher(params, match);
    }

    // If the typed-in term matches the text of this term, or the text from any
    // parent term, then it's a match.
    var original = (data.parentText + ' ' + data.text).toUpperCase();
    var term = params.term.toUpperCase();


    // Check if the text contains the term
    if (original.indexOf(term) > -1) {
        return data;
    }

    // If it doesn't contain the term, don't return anything
    return null;
}
