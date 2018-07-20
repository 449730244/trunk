var loadUrl = document.getElementsByTagName("script")[0].getAttribute("src");

function getCode(url,parm) {
    console.log(" url  "+url);
    var reg = new RegExp("(^|&)"+ parm +"=([^&]*)(&|$)");
    var r = url.substr(url.indexOf("\?")+1).match(reg);
    if (r!=null) return unescape(r[2]); return null;
};

var result = getCode.call(this,loadUrl,"code");
//var result = getCode(loadUrl, 'code');
//alert(getParam(loadUrl, 'name'));

function getJsPath(jsname) {
    var js = document.scripts;
    var jsPath = "";
    for (var i = js.length; i > 0; i--) {
        if (js[i - 1].src.indexOf(jsname) > -1) {
            return js[i - 1].src;
        }
    }
    return jsPath;
}

function getParam(jspath, parm) {
    var urlparse = jspath.split("\?");
    var parms = urlparse[1].split("&");
    var values = {};
    for(var i = 0; i < parms.length; i++) {
        var pr = parms[i].split("=");
        if (pr[0] == parm)
            return pr[1];
    }
    return "";
}


function getUserIP(onNewIP) { //  onNewIp - your listener function for new IPs
    //compatibility for firefox and chrome
    var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new myPeerConnection({
            iceServers: []
        }),
        noop = function() {},
        localIPs = {},
        ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
        key;

    function iterateIP(ip) {
        if (!localIPs[ip]) onNewIP(ip);
        localIPs[ip] = true;
    }

    //create a bogus data channel
    pc.createDataChannel("");

    // create offer and set local description
    pc.createOffer().then(function(sdp) {
        sdp.sdp.split('\n').forEach(function(line) {
            if (line.indexOf('candidate') < 0) return;
            line.match(ipRegex).forEach(iterateIP);
        });

        pc.setLocalDescription(sdp, noop, noop);
    }).catch(function(reason) {
        // An error occurred, so handle the failure to connect
    });

    //sten for candidate events
    pc.onicecandidate = function(ice) {
        if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
        ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
    };
}
