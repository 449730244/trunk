$(document).ready(function(){

    //新建群聊弹出
    $(".ico_add").click(function(){
        var index = layer.load();

        json_get(root_url+'/groupBox', '', function(html){
            layer.close(index);
            layer.open({
                type: 1,
                title: '新建群聊',
                area: ['600px', '400px'],
                shadeClose: true, //点击遮罩关闭
                content: html,
                btn: ['确定', '取消'],
                yes: function(index, layero){

                    layer.close(index);
                }
            });

        }, function(HttpRequest){
            var result =  jQuery.parseJSON(HttpRequest.responseText);
            if (result.statusCode == 1000){ //没有登录
                window.location.href = root_url + '/login';
            }
        },'', false, 'html');

    });

    //新建群聊选择用户交互
    $("body").delegate("#layui-layer1 .check_user_list li","click",function(){
        if ($(this).hasClass('check_ico')){
            $(this).removeClass('check_ico');
        }else{
            $(this).addClass('check_ico');
        }

    });

});