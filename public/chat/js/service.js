var vistor_item = '<li data-id="#id#" data-mark="#mark#" data-type="vistor">\n' +
    '                                <i class="layui-icon layui-icon-face-smile" style="font-size: 30px; color: #1E9FFF;"></i>\n' +
    '                                <div class="vistors_infos">\n' +
    '                                    <span>#name#</span>\n' +
    '                                    <span>#ip#</span>\n' +
    '                                </div>\n' +
    '                                <span class="unreadNum #showClass#">#unreadNum#</span>\n' +
    '                                <span class="time">#time#</span>\n'+
    '                            </li>';

var customer_message_item  = '<div class="say #float#" data-id="#id#" >\n' +
    '                        <div class="say_l ">\n' +
    '                            <div class="circle ">\n' +
    '                                <p class="radius">\n' +
    '                                    <img src="#avatar#" alt="">\n' +
    '                                </p>\n' +
    '                            </div>\n' +
    '                        </div>\n' +
    '                        <div class="say_r  ">\n' +
    '                            <div>\n' +
    '                                <span class="user">#name#</span>\n' +
    '                                <span class="time">#time#</span>\n' +
    '                             </div>\n' +
    '                             <div class="pop">\n' +
    '                                <div class="pop_r ">\n' +
    '                                    <div class="pop_l ">\n' +
    '                                    </div>\n' +
    '                                    <div>#content#</div>\n' +
    '                                </div>\n' +
    '                            </div>\n' +
    '                        </div>\n' +
    '                    </div>';


$(document).ready(function(){
    //点击访客拉取对话记录
    $('body').delegate('.vistors_infos','click',function(){
        var id = $(this).parent().attr('data-id');
        var mark = $(this).parent().attr('data-mark');
        var vistor_name = $(this).find('span').eq(0).text();
        var vistor_avatar = '/chat/img/user.png';
        var type = 'customer';

        $('.vistors li').removeClass('on');
        $(this).parent().addClass('on');
        //显示输入框
        $("#chat_message_box .send").show();
        $("#testdiv").html('');
        $("#chat_message_box input[id='id']").val(id);
        $("#chat_message_box input[id='type']").val(type);
        $("#chat_message_box").attr('data-id', id);
        $("#chat_message_box").attr('data-type', type);
        $("#upload_file").hide();

        $("#customer_box li[data-id="+id+"] .unreadNum").addClass('hide');
        $("#customer_box li[data-id="+id+"] .unreadNum").text("");

        json_get(root_url+"/vistormessage",{mark:mark,service_id:$("#chat_top").data("service_id")},function(result){

            $("#chat_message_box .conversation").html('');
            var data = result.data;
            $(data).each(function(i,item){
                var id = item.id;
                var auth = item.auth;
                var to = item.to;
                var content = item.content;
                var time = item.time;
                var name = "";
                var avatar = "";
                var float = "";
                if (auth == $("#chat_top").data("service_id")){
                    name = $("#chat_top").data('service_name');
                    avatar = $("#chat_top").data('service_avatar');
                    float = "say_right";
                }else{
                    name = vistor_name;
                    avatar = vistor_avatar;
                }
                var message_item = "";
                message_item = customer_message_item.replace(/#float#/g, float);
                message_item = message_item.replace(/#id#/g, id);
                message_item = message_item.replace(/#avatar#/g, avatar);
                message_item = message_item.replace(/#name#/g, name);
                message_item = message_item.replace(/#time#/g, time);
                message_item = message_item.replace(/#content#/g, content);

                $("#chat_message_box .conversation").prepend(message_item);

            });
            $(".conversation").scrollTop($(".conversation")[0].scrollHeight);

        },http_request_error,true,true,'json');
    })
});

function my_vistor(){
    if ($("#customer_box .active li").length == 0 ){
       /* json_get(root_url+'/customer_services/vistors','',function(result){

            var data = result.data;
            var html = '';
            $(data).each(function(i, item){
                html = vistor_item.replace(/#name#/g, item.name);
                html = html.replace(/#ip#/g, item.ip);
                if (item.unreadNum != undefined && item.unreadNum > 0){
                    html = html.replace(/#unreadNum#/g, item.unreadNum);
                }else{
                    html = html.replace(/#unreadNum#/g, '');
                    html = html.replace(/#showClass#/g, 'hide');
                }
                html = html.replace(/#time#/g, item.time);
                html = html.replace(/#id#/g, item.id);
                html = html.replace(/#mark#/g, item.mark);
                $("#customer_box .active").append(html);
            });

        },http_request_error,true,true,'json');*/

        json_get(root_url+'/customer_services/activeVistors','',function(result){

            var active_data = result.active;
            var unActive_data = result.unActive;
            var html = '';
            $(active_data).each(function(i, item){
                html = vistor_item.replace(/#name#/g, item.vistor.name);
                html = html.replace(/#ip#/g, item.vistor.ip);
                html = html.replace(/#unreadNum#/g, '');
                html = html.replace(/#showClass#/g, 'hide');
                html = html.replace(/#time#/g, item.time);
                html = html.replace(/#id#/g, item.vistor.id);
                html = html.replace(/#mark#/g, item.vistor.mark);
                $("#customer_box .active").append(html);
            });
            html = "";
            $(unActive_data).each(function(i, item){
                html = vistor_item.replace(/#name#/g, item.vistor.name);
                html = html.replace(/#ip#/g, item.vistor.ip);
                html = html.replace(/#unreadNum#/g, '');
                html = html.replace(/#showClass#/g, 'hide');
                html = html.replace(/#time#/g, item.time);
                html = html.replace(/#id#/g, item.vistor.id);
                html = html.replace(/#mark#/g, item.vistor.mark);
                $("#customer_box .unactive").append(html);
            });
            showNew();

        },http_request_error,true,true,'json');
    }
}

function vistorMessage(data){
    var vistor_name = data.auth_name;
    var vistor_avatar = '/chat/img/user.png';
    var type = 'customer';

    var msg_str ='';

    msg_str = customer_message_item.replace(/#float#/g, '');
    msg_str = msg_str.replace(/#id#/g, data.msg_id);
    msg_str = msg_str.replace(/#avatar#/g, vistor_avatar);
    msg_str = msg_str.replace(/#name#/g, vistor_name);
    msg_str = msg_str.replace(/#time#/g, data.send_time);
    msg_str = msg_str.replace(/#content#/g, data.content);


    if ($('div[id="chat_message_box"][data-type="customer"][data-id="'+data.vistor_id+'"] .conversation').length > 0){
        $('div[id="chat_message_box"][data-type="customer"][data-id="'+data.vistor_id+'"] .conversation').append(msg_str);
    }else{

        if ($("#customer_box .active li[data-id="+data.vistor_id+"]").length > 0){
            $("#customer_box .active li[data-id="+data.vistor_id+"] .unreadNum").removeClass('hide');
            var count = $("#customer_box .active li[data-id="+data.vistor_id+"] .unreadNum").text();
            if (count !=''){
                $("#customer_box .active li[data-id="+data.vistor_id+"] .unreadNum").text(parseInt(count) + 1);
            }else{
                $("#customer_box .active li[data-id="+data.vistor_id+"] .unreadNum").text(1);
            }
        }else{
            if ($("#customer_box .unactive li[data-id="+data.vistor_id+"]").length > 0){
                $("#customer_box .unactive li[data-id="+data.vistor_id+"] .unreadNum").removeClass('hide');
                var count = $("#customer_box .unactive li[data-id="+data.vistor_id+"] .unreadNum").text();
                if (count !=''){
                    $("#customer_box .unactive li[data-id="+data.vistor_id+"] .unreadNum").text(parseInt(count) + 1);
                }else{
                    $("#customer_box .unactive li[data-id="+data.vistor_id+"] .unreadNum").text(1);
                }
            }else{
                html = vistor_item.replace(/#name#/g, vistor_name);
                html = html.replace(/#ip#/g, data.ip);
                html = html.replace(/#unreadNum#/g, '1');
                html = html.replace(/#showClass#/g, '');
                html = html.replace(/#time#/g, data.time);
                html = html.replace(/#id#/g, data.vistor_id);
                html = html.replace(/#mark#/g, data.mark);
                $("#customer_box .unactive").append(html);
            }
        }

    }
    showNew();
    $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
}

function showNew(){
    if ($("#customer_box .unactive li").length > 0 && $(".vistor_tab li:eq(1) span").length == 0){
        $(".vistor_tab li:eq(1)").prepend('<span>N</span>');
    }else{
        $(".vistor_tab li:eq(1) span").remove();
    }
}