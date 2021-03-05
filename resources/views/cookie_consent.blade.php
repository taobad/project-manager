@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)
<div class="alert text-center cookiealert" role="alert">
    @langapp('cookie_consent_message')

    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        @langapp('cookie_consent_agree')
    </button>
</div>

@push('pagescript')
    
    <script>
       
(function () {
    "use strict";

    var cookieAlert = document.querySelector(".cookiealert");
    var acceptCookies = document.querySelector(".acceptcookies");

    if (!cookieAlert) {
       return;
    }

    cookieAlert.offsetHeight;
    if (!getCookie("acceptCookies")) {
        cookieAlert.classList.add("show");
    }
    acceptCookies.addEventListener("click", function () {
        setCookie("acceptCookies", true, 365);
        cookieAlert.classList.remove("show");
    });
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
})();
    </script>

@endpush
    

@endif