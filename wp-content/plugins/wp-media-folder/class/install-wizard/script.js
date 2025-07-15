(function ($) {
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
    console.log(eventer);
    console.log(messageEvent);
    // Listen to message from child window
    eventer(messageEvent, function (e) {
        console.log("run here");
        console.log(e.data);
        var res = e.data;
        if (typeof res !== "undefined" && typeof res.type !== "undefined" && res.type === "joomunited_connect") {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'wpmfju_update_license',
                    'token': res.token,
                    'ju_updater_nonce': updaterV2params.ju_updater_nonce
                },
                success: function (res) {
                    console.log('success');
                    console.log(res);
                    location.assign(wpmfNextStep);
                //    location.reload();
                }
            });
        }
    }, false);

})(jQuery);