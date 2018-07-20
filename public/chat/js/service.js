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
        $("#chat_message_box input[id='id']").val(id);
        $("#chat_message_box input[id='type']").val(type);
        $("#chat_message_box").attr('data-id', id);
        $("#chat_message_box").attr('data-type', type);

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

        },http_request_error,true,true,'json');
    })
});

function my_vistor(){
    if ($("#customer_box .vistors li").length == 0){
        json_get(root_url+'/customer_services/vistors','',function(result){

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
                $("#customer_box .vistors").append(html);
            });

        },http_request_error,true,true,'json');
    }

}