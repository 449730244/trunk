includeLinkStyle('http://www.ichat.com/chat/css/css.css');
includeScript('http://www.ichat.com/chat/js/jquery.min.js');
window.onload = function()
{

    $.getJSON('http://www.ichat.com/customerServices?jsoncallback=?',function (data) {
//console.log(data);
        var html ='';
        html += '<div class="customer">' +
            '    <div class="top">' +
            '        <span class="title">在线客服</span>' +
            '        <span class="close">X</span>' +
            '    </div><div class="content_list">';
        $.each(data,function (key,val) {

            html += ' <a href="http://www.ichat.com/showPage?customer_id='+ val.id +'" target="_blank">' +
                '     <div class="list">' +
                '      <span class="img"><img src="http://www.ichat.com/'+ val.avatar +'" /></span>' +
                '      <span class="name offline">'+ val.name +'</span>' +
                '     </div></a>';
        });
        html +='</div></div>';
        var body = document.body;
        body.innerHTML += html;
    },'jsonp');
}

function includeLinkStyle(url) {
    var link  = document.createElement("link");
    link.rel   = "stylesheet";
    link.type = "text/css";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

function includeScript(url){
    var script=document.createElement("script");
    script.type = "text/javascript";
    script.src  = url;
    document.getElementsByTagName('head')[0].appendChild(script);
}

