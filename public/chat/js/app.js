/**
 * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
 * 其中端口为Gateway端口，即start_gateway.php指定的端口。
 * start_gateway.php 中需要指定websocket协议，像这样
 * $gateway = new Gateway(websocket://0.0.0.0:7272);
 */
$(document).ready(function() {
    ws = new WebSocket("ws://192.168.1.240:98");
// 服务端主动推送消息时会触发这里的onmessage
    ws.onmessage = function (e) {
        // json数据转换成js对象
        var data = eval("(" + e.data + ")");
        console.log('server_return----', data);
        var type = data.type || '';
        switch (type) {
            // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
            case 'init':
                bind(data);
                break;
            // 新建群聊
            case 'group_create':
                group_create(data);
                break;
            //用户退出群聊
            case 'group_exit':
                group_exit(data);
                break;
            //群主添加新成员，向成员发送新群信息
            case 'group_adduser':
                group_adduser(data);
                break;
            //移除群聊
            case 'group_removeuser':
                group_removeuser(data);
                break;
            //更新群名称
            case 'group_updatename':
                group_updatename(data);
                break;
            //解散群组
            case 'group_delete':
                group_delete(data);
                break;
            case 'user':
                messageShowToUser(data);
                break;
            case 'group':
                messageShowToGroup(data);
                break;
            default :
            // alert(e.data);
        }
    };

});

function bind(result){
    var loading = layer.load(); //提交中的效果
    $.ajax({
        url: '/bind',
        type: "GET",
        processData: true,
        cache: false,
        async: false,
        data: {client_id: result.client_id},
        dataType: 'json',
        success: function(result){

            $('meta[name="csrf-token"]').attr('content', result.csrf_token);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': result.csrf_token
                }
            });

            //$("#chat_top .chart_r .username").html(result.name);
            // $("#auth_user_name").text(result.name);
            $("#chat_top").data("userid", result.user_id); //当前登录用户ID
            t_user_id = result.user_id;
            t_avatar = result.avatar;
            $("#user_head").attr('src',t_avatar);

            initMessageQueue();
            layer.close(loading); //提交完成关闭效果
        },
        error: http_request_error
    });
}
