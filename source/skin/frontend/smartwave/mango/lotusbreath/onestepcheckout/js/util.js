(function($) {
    var re = /([^&=]+)=?([^&]*)/g;
    var decodeRE = /\+/g;  // Regex for replacing addition symbol with a space
    var decode = function (str) {return decodeURIComponent( str.replace(decodeRE, " ") );};
    $.parseParams = function(query) {
        var params = {}, e;
        while ( e = re.exec(query) ) {
            var k = decode( e[1] ), v = decode( e[2] );
            if (k.substring(k.length - 2) === '[]') {
                k = k.substring(0, k.length - 2);
                (params[k] || (params[k] = [])).push(v);
            }
            else params[k] = v;
        }
        return params;
    };
    $.getUrlQueryParam = function( url, key ) {
        var queryStartPos = url.indexOf('?');
        if (queryStartPos === -1) {
            return;
        }
        var params = url.substring(queryStartPos + 1).split('&');
        for (var i = 0; i < params.length; i++) {
            var pairs = params[i].split('=');
            if (decodeURIComponent(pairs.shift()) == key) {
                return decodeURIComponent(pairs.join('='));
            }
        }
    };

    $(document).ready(function() {
        $(".block-control .different-address-textbox").change(function() {
            if(this.checked) {
                $(".block-control > ul .different-address input").click();
            } else {
                $(".block-control > ul .this-address input").click();
            }
        });
        $('.d3-additional .newsletter-block').html('');
        $('.discount-cart.d3 .newsletter').detach().appendTo('.d3-additional .newsletter-block');

        $('#checkout-shipping-method-load .sp-methods').detach().appendTo('.d3-additional .shipping-block');
    });
})(jQuery);

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

