/**
 * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
 * 其中端口为Gateway端口，即start_gateway.php指定的端口。
 * start_gateway.php 中需要指定websocket协议，像这样
 * $gateway = new Gateway(websocket://0.0.0.0:7272);
 */
$(document).ready(function() {
    ws = new WebSocket("ws://192.168.1.240:98");
    ws.onmessage = function (e) {
        // json数据转换成js对象
        var data = eval("(" + e.data + ")");
        console.log('server_return----', data);
        var type = data.type || '';
        switch (type) {
            case 'init':
                bind(data);
                break;
            case 'vistorMessage':
                customerMessage(data);
                break;
            default :
        }
    };
    getMessage();

    //消息发送
    $('#send').click(function(){
        send();
    });
});

function bind(result){

    var send_data;

    if(localStorage.getItem('guest') == 'undefined')
    {
        send_data = {
            client_id: result.client_id,
            mark:''
        };
    }else{
        var guest = localStorage.getItem('guest');
        send_data = {
            client_id: result.client_id
            ,mark:guest
        };
    }
    $.ajax({
        url: '/vistorsBind',
        type: "GET",
        processData: true,
        cache: false,
        async: false,
        data: send_data,
        dataType: 'json',
        success: function(result){
            console.log('-------------result',result);
            localStorage.setItem('guest',result.mark);
            $('meta[name="csrf-token"]').attr('content', result.csrf_token);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': result.csrf_token
                }
            });
        }
    });
}


function send()
{
    var customer = $('#customer').attr('data-id');
    var guest = localStorage.getItem('guest');
    console.log('customer--------------',customer);
    console.log('guest--------------',guest);
    var content = $('#content').html();
    console.log('content---------',content);
    if(content == '')
    {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.alert('请输入发送内容');
        });
        return false;
    }
    $.post('/vistor/say',
        {
            'service_id':customer,
            'mark'   :guest,
            'content' : content
        } ,function (data) {
        $('#content').empty();
        console.log('sayReturn------',data);
        showMessage(data);
    },'json');

}

function showMessage(data)
{
    var str = '';
        str += '<li class="layim-chat-mine">' +
            '      <div class="layim-chat-user">' +
            '         <img src="/chat/img/user.png">' +
            '          <cite><i>'+ data.send_time +'</i>'+ data.auth_name +'</cite>' +
            '      </div>' +
            '      <div class="layim-chat-text">'+ data.content+'</div>' +
            ' </li>';
        $('.messagelist ul').append(str);
    $(".messagelist").scrollTop($(".messagelist")[0].scrollHeight);
}

function customerMessage(data)
{
    var str='';
         str+= '<li>' +
            '   <div class="layim-chat-user">' +
            '     <img src="'+ data.auth_avatar +'">' +
            '     <cite>'+ data.auth_name +'<i>'+ data.time +'</i></cite>' +
            '   </div>' +
            '   <div class="layim-chat-text">'+ data.content +'</div>' +
            '  </li>';
    $('.messagelist ul').append(str);
    $(".messagelist").scrollTop($(".messagelist")[0].scrollHeight);
}

//获取聊天消息
function getMessage()
{
    var mark = localStorage.getItem('guest');
    var service_id = $('#customer').attr('data-id');
    var avatar = $('#customer').find('img').attr('src');
    var isOnline = $('#customer').attr('data-online');
    $.get('/vistormessage',{mark:mark,service_id:service_id},function (data)
    {
        console.log(data);
        $.each(data.data,function(k,v){
            var str = '';
            if(v.auth == service_id )
            {
                str+= '<li>' +
                    '   <div class="layim-chat-user">';
                if(isOnline ==1){
                 str +=  '<img src="'+ avatar +'">';
                }else{
                 str += '<img src="'+ avatar +'" class="offline-img">';
                }
                if(v.service != '')
                {
                    str +=  '<cite>'+ v.service.name +'<i>'+ v.time +'</i></cite>';
                }
                str += '</div><div class="layim-chat-text">'+ v.content +'</div></li>';
            }else{
                str += '<li class="layim-chat-mine">' +
                    '      <div class="layim-chat-user">' +
                    '         <img src="/chat/img/user.png">';
                    if(v.vistor != '')
                    {
                        str += '<cite><i>'+ v.time +'</i>'+ v.vistor.name +'</cite>';
                    }
                str +='</div><div class="layim-chat-text">'+ v.content+'</div></li>';
            }
            $('.messagelist ul').prepend(str);
        });
        if(isOnline !=1)
        {
            var online_str ='';
            online_str += '<li class="tips"><p>当前客服已离线，请选择其他客服咨询。</p><span class="time">'+ new Date().toLocaleTimeString() +'</span></li>';
            $('.messagelist ul').append(online_str);
        }
        $(".messagelist").scrollTop($(".messagelist")[0].scrollHeight);
    });
}
