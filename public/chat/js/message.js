
//消息发送
function send() {

    var uid = $("#chat_top").data('userid'); //当前登录用户ID
    var current_box =  $('#chat_message_box').attr('data-id');
    var id = $('#id').val();  //群或人ID
    var type = $('#type').val(); // 类型：群group，私聊：user
    if(id == '' || type == '')
    {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.alert('请选择聊天对象');
        });
        return ;
    }
    var content = $('#testdiv').html();
    console.log('content---------',content);
    if(content == '')
    {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.alert('请输入发送内容');
        });
        return ;
    }
    var url;
    var send_data;
    //群消息内容封装
    if(type == 'group')
    {
        url = '/sendGroupMessage';
        send_data = {
            'group_id':id,
            'type':type,
            'content':content
        };
    }else{
        url = '/sendPrivateMessage';
        send_data = {
            'to_user_id':id,
            'type':type,
            'content':content
        };
    }
    var msg_str = '';
    json_post(url,send_data,function(data){
        $('#testdiv').empty();
        messageShow(id,type,data);
    });

}

    //初始化消息队列
    function initMessageQueue()
    {
        json_get('/getQueueList',{},function(data){
            console.log('消息队列-------',data);
            var str='';
            var read_num =0;
            $('#message_box .member_bot').empty();
            $.each(data,function(key,val){
                str += '<div class="outer" id="outer_'+ val.type +'_'+ val.from_id +'" data-type="'+ val.type +'" data-id ="'+ val.from_id +'"><div class="people_out outer"><div class="peoples fl" data-type="'+ val.type +'" data-id ="'+ val.from_id +'">';
                if(val.content)
                {
                    var msg_content = $.parseJSON(val.content);
                    if(val.type == 'group')
                    {
                        str += '<div class="circle fl"><p class="radius"><img src="/chat/img/grouphead.png" alt=""></p></div>';
                    }else{
                        if(val.user.avatar)
                        {
                            str += '<div class="circle fl"><p class="radius"><img src="'+ val.user.avatar +'" alt=""></p></div>';
                        }else{
                            str += '<div class="circle fl"><p class="radius"><img src="img/error_head.jpg" alt=""></p></div>';
                        }
                    }
                    str +='<div class="mg fl"><p class="tit otw">'+ val.name +'</p>';
                        if(msg_content.content != null)
                        {
                            var content = replace_html(msg_content.content);
                            if(content.length >10 )
                            {
                                content = content.substring(0,10)+ "....";
                            }
                            str += '<p class="detail otw" id="detail_'+ val.from_id +'">'+ content +'</p>';
                        }
                    }
                    str += '</div>' +
                    '<div class="fl" style="width: 40px;margin-top: 23px;">' +
                    '<p class="times" id="times_'+ val.from_id +'">'+ val.updated_at.substr(11,5)+'</p>';
                if(val.unread > 0)
                {
                    str +=  '<p class="read_num _red" id="read_num_'+ val.from_id +'">'+ val.unread+'</p>';
                }else{
                    str +=  '<p class="read_num hid" id="read_num_'+ val.from_id +'"></p>';
                }
                str +=  '<p class="close" id="close_'+ val.from_id +'" ><i class="layui-icon layui-icon-close-fill"></i></p>';

                str += '</div></div></div></div>';
                read_num += val.unread;
            });
            if(read_num >0){
                $('#new_msg').addClass('new_msg');
            }else{
                $('#new_msg').removeClass('new_msg');
            }
            $(str).appendTo('#message_box .member_bot');
        },http_request_error,true, true,'json');
    }
/**
 * 消息对话渲染
 */
function messageShow(id,type,data)
{
    console.log('messageShow=========',data);
    var content = replace_html(data.content.content);
    if(content.length >10 )
    {
        content = content.substring(0,10)+ "....";
    }
    $('#outer_'+ type +'_'+ id).find('#detail_'+ id).empty();
    $('#outer_'+ type +'_'+ id).find('#detail_'+ id).html(content);
    $('#outer_'+ type +'_'+ id).find('#times_'+ id).html(data.updated_at.substr(11,5));

    if(type == 'user')
    {
        var msg_str ='';
        msg_str += '<div class="say say_right" data-id="'+ data.msg_id +'" data-userid="'+ data.user_id+'">';
        msg_str += '<div class="say_l "><div class="circle "><p class="radius"><img src="'+ data.content.headimg+'" alt=""></p></div></div>';
        msg_str +=  '<div class="say_r ">' +
            '               <div>' +
            '                   <span class="user">'+ data.content.user_name+'</span>' +
            '                   <span class="time">'+ data.updated_at +'</span>' +
            '                </div>';
        if(data.content.file_id)
        {
            msg_str += '<div class="file_style">' +
                '         <div class="file_menu">' +
                '           <span class="down" data-fileid="'+ data.content.file_id +'"></span>' +
                '         </div>' +
                '         <div class="file_infos">' +
                '             <span>'+ data.content.file_name +'</span>' +
                '             <span>'+ data.content.file_size +'</span>' +
                '         </div>' +
                '       </div>';
        }else {
            msg_str += ' <div class="pop">' +
                '                    <div class="pop_r ">' +
                '                       <div class="pop_l ">' +
                //'                          <img src="img/pop_left.png" alt="">' +
                '                        </div>' +
                '                          <p>' + data.content.content + '</p>' +
                '                      </div>' +
                '         </div>';
        }
        msg_str += '</div></div>';
        $('.conversation').append(msg_str);
        $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
    }
}

function messageShowToUser(data)
{
    var uid = $("#chat_top").data('userid');

    if($('#outer_'+ data.type +'_'+ data.user_id).length == 0)
    {
        $('#outer_'+ data.type +'_'+ data.user_id).remove();
        if(data.to_user_id == uid)
        {
            addUserQueueDom(data);
        }
    }else{
        //消息队列渲染
        $('#outer_'+ data.type +'_'+ data.user_id).find('#detail_'+ data.user_id).empty();
        var content = replace_html(data.content.content);
        if(content.length >10 )
        {
            content = content.substring(0,10)+ "....";
        }

        $('#outer_'+ data.type +'_'+ data.user_id).find('#detail_'+ data.user_id).html(replace_html(content));
        $('#outer_'+ data.type +'_'+ data.user_id).find('#times_'+ data.user_id).html(data.updated_at.substr(11,5));
        $('#outer_'+ data.type +'_'+ data.user_id).find('#read_num_'+data.user_id).removeClass('hid');
        $('#new_msg').addClass('new_msg');

        if(data.to_user_id == uid)
        {
            var read_num  = $('#read_num_'+data.user_id).text();
            console.log('read_num-------',read_num);
            if(read_num !='')
            {
                $('#read_num_'+data.user_id).text(parseInt(read_num) + 1);
            }else{
                $('#read_num_'+data.user_id).text(1);
            }
            $('#read_num_'+data.user_id).addClass('_red');
        }
        //聊天框渲染
        var id = $('#chat_message_box').attr('data-id');
        console.log('id---------------',id);
        if(id == data.user_id)
        {
            var msg_str ='';
            if(data.user_id == uid)
            {
                msg_str += '<div class="say say_right" data-id="'+ data.msg_id+'" data-userid="'+ data.user_id +'">';
            }else{
                msg_str += '<div class="say" data-id="'+ data.msg_id+'" data-userid="'+ data.user_id +'">';
            }
            msg_str += '<div class="say_l "><div class="circle "><p class="radius"><img src="'+ data.content.headimg+'" alt=""></p></div></div>';
            msg_str +=  '<div class="say_r ">' +
                '               <div>' +
                '                   <span class="user">'+ data.content.user_name+'</span>' +
                '                   <span class="time">'+ data.updated_at +'</span>' +
                '                </div>';
            if(data.content.file_id)
            {
                msg_str += '<div class="file_style">' +
                    '         <div class="file_menu">' +
                    '           <span class="down" data-fileid="'+ data.content.file_id +'"></span>' +
                    '         </div>' +
                    '         <div class="file_infos">' +
                    '             <span>'+ data.content.file_name +'</span>' +
                    '             <span>'+ data.content.file_size +'</span>' +
                    '         </div>' +
                    '       </div>';
            }else {
                msg_str += ' <div class="pop">' +
                    '                    <div class="pop_r ">' +
                    '                       <div class="pop_l ">' +
                   // '                          <img src="img/pop_left.png" alt="">' +
                    '                        </div>' +
                    '                          <p>' + data.content.content + '</p>' +
                    '                      </div>' +
                    '         </div>';
            }
            msg_str += '</div></div>';
            $('.conversation').append(msg_str);
            $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
        }
    }
}

function messageShowToGroup(data)
{
    console.log('groupData====',data);
    var uid = $("#chat_top").data('userid');
    if($('#outer_'+ data.type +'_'+ data.group_id).length == 0)
    {
        if(data.user_id != uid)
        {
            addGroupQueueDom(data);
        }
    }else{
        $('#outer_'+ data.type +'_'+ data.group_id).find('#detail_'+ data.group_id).empty();
        $('#outer_'+ data.type +'_'+ data.group_id).find('#detail_'+ data.group_id).html(replace_html(data.content.content));
        $('#outer_'+ data.type +'_'+ data.group_id).find('#times_'+ data.group_id).html(data.updated_at.substr(11,5));
        $('#outer_'+ data.type +'_'+ data.group_id).find('#read_num_'+data.group_id).removeClass('hid');

        if(data.user_id != uid)
        {
            var read_num  = $('#read_num_'+ data.group_id).text();
            console.log('read_num-------',read_num);
            if(read_num !='')
            {
                $('#read_num_'+data.group_id).text(parseInt(read_num) + 1);
            }else{
                $('#read_num_'+data.group_id).text(1);
            }
            $('#read_num_'+data.group_id).addClass('_red');
            $('#new_msg').addClass('new_msg');
        }
        var id = $('#chat_message_box').attr('data-id');

        if(id == data.group_id)
        {
            var msg_str ='';
            if(data.user_id == uid){
                msg_str += '<div class="say say_right" data-id="'+ data.msg_id+'" data-userid="'+ data.user_id +'">';
            }else{
                msg_str += '<div class="say" data-id="'+ data.msg_id+'" data-userid="'+ data.user_id +'">';
            }
            msg_str += '<div class="say_l "><div class="circle "><p class="radius"><img src="'+ data.content.headimg+'" alt=""></p></div></div>';
            msg_str +=  '<div class="say_r ">' +
                '               <div>' +
                '                   <span class="user">'+ data.content.user_name+'</span>' +
                '                   <span class="time">'+ data.updated_at +'</span>' +
                '                </div>';
            if(data.content.file_id)
            {
                msg_str += '<div class="file_style">' +
                    '         <div class="file_menu">' +
                    '           <span class="down" data-fileid="'+ data.content.file_id +'"></span>' +
                    '         </div>' +
                    '         <div class="file_infos">' +
                    '             <span>'+ data.content.file_name +'</span>' +
                    '             <span>'+ data.content.file_size +'</span>' +
                    '         </div>' +
                    '       </div>';
            }else {
                msg_str += ' <div class="pop">' +
                    '                    <div class="pop_r ">' +
                    '                       <div class="pop_l ">' +
                   // '                          <img src="img/pop_left.png" alt="">' +
                    '                        </div>' +
                    '                          <p>' + data.content.content + '</p>' +
                    '                      </div>' +
                    '         </div>';
            }
            msg_str += '</div></div>';
            $('.conversation').append(msg_str);
            $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
        }
    }
}

function addUserQueueDom(data)
{
    var str = '';
    str += '<div class="outer" id="outer_'+ data.type +'_'+ data.user_id +'"><div class="people_out outer"><div class="peoples fl" data-type="'+ data.type +'" data-id ="'+ data.user_id +'">';
    if(data.content)
    {
        if(data.type == 'group')
        {
            str += '<div class="circle fl"><p class="radius"><img src="/chat/img/grouphead.png" alt=""></p></div>';
        }else{
            if(data.content.headimg)
            {
                str += '<div class="circle fl"><p class="radius"><img src="'+ data.content.headimg +'" alt=""></p></div>';
            }else{
                str += '<div class="circle fl"><p class="radius"><img src="img/error_head.jpg" alt=""></p></div>';
            }
        }
        str +='<div class="mg fl"><p class="tit otw">'+ data.content.user_name +'</p>';
        if(data.content.content != null)
        {
            var content = replace_html(data.content.content);
            if(content.length >10 )
            {
                content = content.substring(0,10)+ "....";
            }
            str += '<p class="detail otw" id="detail_'+ data.user_id +'">'+ content +'</p>';
        }
    }
    str += '</div>' +
        '<div class="fl" style="width: 40px;margin-top: 23px;">' +
        '<p class="times" id="times_'+ data.user_id +'">'+ data.updated_at.substr(11,5)+'</p>';
    str +=  '<p class="read_num _red" id="read_num_'+ data.user_id +'">1</p>';
    str +=  '<p class="close" id="close_'+ data.user_id +'"><i class="layui-icon layui-icon-close-fill"></i></p>';
    str += '</div></div></div></div>';
    $(str).appendTo('#message_box .member_bot');
}

function addGroupQueueDom(data)
{
    var str = '';
    str += '<div class="outer" id="outer_'+ data.type +'_'+ data.group_id +'"><div class="people_out outer"><div class="peoples fl" data-type="'+ data.type +'" data-id ="'+ data.group_id +'">';
    if(data.content)
    {
        str += '<div class="circle fl"><p class="radius"><img src="/chat/img/grouphead.png" alt=""></p></div>';
        str +='<div class="mg fl"><p class="tit otw">'+ data.group_name +'</p>';
        if(data.content.content != null)
        {
            var content = replace_html(data.content.content);
            if(content.length >10 )
            {
                content = content.substring(0,10)+ "....";
            }
            str += '<p class="detail otw" id="detail_'+ data.group_id +'">'+ content +'</p>';
        }
    }
    str += '</div>' +
        '<div class="fl" style="width: 40px;margin-top: 23px;">' +
        '<p class="times" id="times_'+ data.group_id +'">'+ data.updated_at.substr(11,5)+'</p>';
    str +=  '<p class="read_num _red" id="read_num_'+ data.group_id +'">1</p>';
    str +=  '<p class="close" id="close_'+ data.group_id +'"><i class="layui-icon layui-icon-close-fill"></i></p>';
    str += '</div></div></div></div>';
    $(str).appendTo('#message_box .member_bot');
}

$(document).ready(function () {

    $('#testdiv').keydown(function (e) {
        if(e.keyCode == 13)
        {
            e.preventDefault();
            send();
        }
    });


    $('body').delegate('.peoples','click',function (){
        $('.conversation').empty();
        //获取当前点击的聊天类型和id
        console.log('userid----------',$("#chat_top").data('userid'));
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-id');

        $('#message_box .member_bot .peoples').removeClass('on');
        $('#message_box .member_bot div[data-id="'+id+'"]').addClass('on');
        $('#new_msg').removeClass('new_msg');

        //给隐藏input 赋值
        $('#id').val(id);
        $('#type').val(type);
        $('#chat_message_box').attr('data-id',id);
        $('#chat_message_box').attr('data-type',type);

        get_message_list(id,type,1);

    });

    $('body').delegate('.close','click',function(e){
       var id = $(this).parents('.peoples').attr('data-id');
        var type = $(this).parents('.peoples').attr('data-type');

        console.log('id----------',id);
        console.log('type----------',type);
        json_get('/delQueue',{'from_id':id,'type':type},function (data){
            $('#outer_'+ type +'_' + id ).remove();
            $('#chat_message_box .conversation ').empty();
        },http_request_error,true, true,'json');
        e.stopPropagation();
    });
});




