includeLinkStyle('http://www.ichat.com/chat/css/customer_service.css');
includeScript('http://www.ichat.com/chat/js/jquery.min.js');
window.onload = function()
{

    $.getJSON('http://www.ichat.com/customerServices?jsoncallback=?',function (data) {

//console.log(data);
        var html ='<div class="online-customer"><span>在线客服</span></div>';
        html += '<div class="customer">' +
            '    <div class="top">' +
            '        <span class="title">在线客服</span>' +
            '        <span class="customer-close" id="customer_close">x</span>' +
            '    </div><div class="content_list">';
        $.each(data,function (key,val) {
            html += ' <a href="javascript:void(0);" target="_blank" class="open_new_wind" data-id="'+ val.id +'">' +
                '     <div class="list">';
            if(val.isonline == 1)
            {
                html += '<span class="img"><img src="http://www.ichat.com/'+ val.avatar +'" /></span><span class="name">'+ val.name +'</span></div></a>';
            }else{
                html += '<span class="img"><img src="http://www.ichat.com/'+ val.avatar +'" class="offline-img" /></span><span class="name offline">'+ val.name +'</span></div></a>';
            }
        });
        html +='</div></div>';
        var body = document.body;
        body.innerHTML += html;
    },'jsonp');

    $('body').delegate('#customer_close','click',function () {
        $('.customer').addClass('customer_hid');
        $('.online-customer').addClass('online-customer-show');
    });
    
    $('body').delegate('.online-customer','click',function () {
        $('.customer').removeClass('customer_hid');
    });
    $('body').delegate('.open_new_wind','click',function () {
        var id = $(this).attr('data-id');
        window.open("http://www.ichat.com/showPage?customer_id="+id,"_blank","toolbar=no,top=100,left=200, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, width=1200, height=850");
    })

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

