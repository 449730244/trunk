<!DOCTYPE html>
<html>
<head>
    <title>在线客服</title>
    <meta name="csrf-token" content="">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/chat/layui/css/layui.css">
    <link rel="stylesheet" href="/chat/jquery-emoji/css/jquery.mCustomScrollbar.min.css" />
    <link rel="stylesheet" href="/chat/jquery-emoji/css/jquery.emoji.css" />
    <link rel="stylesheet" href="/chat/css/customer.css" />
    <link rel="stylesheet" href="/chat/css/chatBox.css">
    <script src="/chat/js/jquery.min.js"></script>
    <script src="/chat/layui/layui.all.js"></script>
    <script src="/chat/jquery-emoji/js/jquery.mousewheel-3.0.6.min.js"></script>
    <script src="/chat/jquery-emoji/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="/chat/jquery-emoji/js/jquery.emoji.js"></script>

    <script src="/chat/js/customer_msg.js"></script>


    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-container chatbox layui-layer-content">

    <div class=" layui-col-md12 chat_top">
        <div class="top" id="customer" data-id="{{$cuscomer_id}}"><span>{{$customer_name}}</span></div>
    </div>
    <div class=" layui-col-md9 messagebox layim-chat-box">
        <div class="layim-chat-main messagelist">
            <ul>
                <li>
                    <div class="layim-chat-user">
                        <img src="//wx2.sinaimg.cn/mw690/5db11ff4gy1flxmew7edlj203d03wt8n.jpg">
                        <cite>王祖贤<i>2018-07-20 15:36:27</i></cite>
                    </div>
                    <div class="layim-chat-text">哈哈哈哈</div>
                </li>
                <li class="layim-chat-mine">
                    <div class="layim-chat-user">
                        <img src="//res.layui.com/images/fly/avatar/00.jpg">
                        <cite><i>2018-07-20 15:36:30</i>纸飞机</cite>
                    </div>
                    <div class="layim-chat-text">同仁堂</div>
                </li>
            </ul>
        </div>
        <div class="sendbox" >
            <div class="sendtools">
                <ul>
                    <li class="layui-icon layui-icon-face-smile" id="emoji"></li>
                    <li class="layui-icon layui-icon-picture" ></li>
                </ul>
            </div>
            <div class="sendcontent" contenteditable="true" id="content"></div>
            <div class="sendbutton">
                <button class="layui-btn layui-btn-normal" id="send">发送</button>
            </div>
        </div>
    </div>
    <div class="layui-col-md3">
        <div class="grid-demo newsbox">

        </div>
    </div>
</div>
</body>
<script type="text/javascript">
 $(document).ready(function(){
        $('#content').emoji({
            button:'#emoji',
            showTab: false,
            animation: 'fade',
            position: 'topRight',
            icons: [{
                name: "QQ表情",
                path: "/chat/jquery-emoji/img/qq/",
                maxNum: 91,
                excludeNums: [41, 45, 54],
                file: ".gif",
                placeholder: "#qq_{alias}#"
            }]
        });
    });
</script>
</html>