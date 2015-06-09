(function (window, document, undefined) {
    "use strict";
    function messageReceived(text, id, channel) {
        var objDiv = document.getElementById('messages');
        var text = JSON.parse(text);
        objDiv.innerHTML += id + ': ' + text.text + '<br>';
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    function ready(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    ready(function () {
        var pushstream = new PushStream({
            host: window.location.hostname,
            port: window.location.port,
            modes: "websocket|eventsource|stream",
        });
        pushstream.onmessage = messageReceived;
        pushstream.addChannel('foochannel');
        pushstream.connect();
    });
})(window, document);