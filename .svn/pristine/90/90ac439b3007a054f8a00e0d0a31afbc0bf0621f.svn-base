window.onload = function () {
    body = document.body

    //绘制界面

    //点击事件监听
    document.addEventListener('click', function (e) {
        var chat = document.getElementsByClassName("chat");
        var target = event.target;
        log(target.className)
        if(target.className.toLowerCase() == "waiter"){
            link()
        }else
        if(target.className.toLowerCase() == "closechat"){
            log(123)
            closeChat()
        }else
       {
           openWin()
        }
    })


    /**
     * 初始化界面信息
     */
    var css = "body{} .chat *{text-decoration: none;margin:0; padding:0;list-style:none;}" +
        ".waiter{color:white} .waiter img{width:20px}" +
        "iframe{width:600px;height:400px;border:none;scroll:overflow;position: fixed;z-index: 998;left: 30%;bottom: 20%;padding: 5px;}";
    loadStyleString(css);


    var html = '<div class="chat" style="width:100px;background-color:#00a7d0;position: fixed;z-index: 999;right: 0px;bottom: 10%;padding: 5px;"> ' +
        '<h3>联系我们</h3>' +
        '<ul>' +
        '    <li id="waiter1" class="waiter"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAA+CAMAAABeI7j4AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5OUQ4Q0ZEQThCMjQxMUU4QTk3N0Y1RTBDQkVCNzE2MiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo5OUQ4Q0ZEQjhCMjQxMUU4QTk3N0Y1RTBDQkVCNzE2MiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjk5RDhDRkQ4OEIyNDExRThBOTc3RjVFMENCRUI3MTYyIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjk5RDhDRkQ5OEIyNDExRThBOTc3RjVFMENCRUI3MTYyIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+LwbSnQAAAwBQTFRF/t61JKT9lkIes4hw/7J3///6rnFN/fPt1eX66IZMpUsl/6Ft59nT0bivIpv7/8mT/+a6fCsKhDgYAWP9VFRUzc3O/+K1iIiI/82ZNzg4eHl5wl0xVZT5////SDkz/cmlHpL7l775baf5lWpRnUYi5NXO/9WrJnf5izsa/ufYl1Y5UEY+/76Exdv8yWI0gTUWjEYoDILyvdX5djYcJico/9Wm/7+F2cO6/vr5G3X5/+zC9vLw/7KB7uTfQIn5IJX8s1Qr/55qAFn+NoP5zOb5/8WNalBCA2n5icb/7JdjBXrs6/P95O37C3/z//v633tCbTcq/9CdC3L7v1sw/7uM/9qpxqaYFGz6+8OUA3HzAFb9/6Rx/76C/618R0Js/8WK+dfA4nY8/8acEVfP/vnw/92u+fb0/8KIkj8c69/aoEMeAF/9jV1G/5li/9WjhTAKHI/7/9atulguAm72EX/5osX6gDIRjbn58Pb+68yj8ern9fn+1auD//DFxIVY/9KgZJz5rFAo02o0241i9O7rCH7vCmX6vKGY/9CmVzMj/vz7YWJjvZSDp3xigzYWD4X1BnvtA3jtJI74/9el/e7jEoj29Jtp/v3++v//gSwJuIJc/c6zAnXv3HA3iG50/+q/9ZxghTgXmJiYgzcXHSMnolk1iDkYw45oDGv7LzM1+/z8E437/Pr6/9Ooa8H4/92rBV76wZRrAFr7///9+vn4/8iK/ql1ijcQAXjrKy4vkk8yDnn7/uHG4M7GAFv9GIf7gjQU/P3/gDMT/9us5cOc7qFp2LOLBXz3+cGM98qX+Pv/4q5+//DSt9Dr9bV+aXKiiEEiAGP1s7OzAFHl8NSt9tuwQSUZPS4oMC8vkaPRaisS4LeNfS4NEV/tJpH1/+zN1uDv3fD/P2nCA3b7BHr9CHfzAFT3/7p//7aGpND0tM/4rl40/76QGY/5fmJOS4TMhzYUs8bY/sOPTjJM8KdxQ6z/xV8yfaz4bm9vBXzs8Ofj/eTJy5xxA3nsgDAP////OypGpAAAAQB0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAe3SURBVHjahNYNXBPnHQfwNBAaEnm5C0UwuQIS5Xg9qgGCKIQgZFqMQgaMVIbVIldiKYJGtKUYbSlGDVCkKVZL49EUamktCvJSEejcS7c5uq2VddnWvaDM4sbe8GUj9P8kBDiwn/1JArl7vvn9n3vujnBmFhdxyMstYmQkNtTNa1mSeWZpcRa9NyaE6u16E4NbJgf1dlPElf9HzFdGsEELPl+D9tzchEPmbyfvn8QGGQbHGcpqhSeJsN2G2fq8jN9CdkfYGIYmKYqUSq3oyaAgC0nqsb4NDyWXQHAVYo3BUC7gGgy0lUsiY6EFCq4eW/UQYjxp48JggzhmSqHQAFJwHSk4Y5KKFVbbg6XEq1kqJWnDlFgsntIoysUGkkHGCogiNeWTfebFZDduseDScoNBI0ZoaspgEUgp3DKCoih6yoB5LSa5NhynubhUg2LAlJNSMYmbBt+h7BQYwRQZa2ST90dMsMOqiJkqLwcgFlDSGAE1PPxu9U89SD30pxG4joCLrMLQNDVig1QAXSloShADUx550bexMevfX+shxmA7wSYn7FZSYJBaSMhRcCn4VU5iEQdbckqzfArdPYYZ2qCPMC8k72V8cYOkTZQUloWmGIEmRjFpO+27jpNTGuBTeMv962Er10TtXkDM51Ycl8nWWqUCLj5skZbHaATQVFWLf1FOtYNcI00W3HZoAXlsxfLlfq03rMwwRUOCRjCJefy6ytfX/5PG6oD04nh3iMFx7Nl5YlwOtQJiuAKFptzAtWCxL65b5+vry0FTSY+Pv+W+dRDIqnmSdA+RUdk2qZQmcQrDT38OEbMhPsWIeOIMi7zsJK3HJimGspk8Dla1OETRbEh8lLsnTbFTjgO5J5MduzxoIz1+UIV6AgFtOUMQ4bIJgYifTPblYN+7B2cBykBtFcajchDbAjLzy0h0kG+c/q3/HOB84shIL3aSrShl2QIydK9VJpNFfu7L8XdWEUQsEPHdZ+Fysy0kM8u+6B1tD/zhhzk5RahychrjqrNcIird5+0Yhr0uQJofDwzsdcspLW1EVVqKgE+hMyMqp8tTAVeAjUVWIdL+t4CALGcFAHA1FeXj774VrjYc28Aizx8DEnndByoAvaSnF8+K+KgPixx94TY2aV4bCOalrnRHFRbPAZjJun9uNQxb4bR8wCKYFXWW4R4/N3SOFPm+fcRiLSEZ1pk8c8VmHWmHnJduLSZRPlU/flpAlSDyMotgeAnEjEZei1qc4s/xnKJoROxLCNfR2rViVs72xpZNR2hrycOIhVsyEohyTl/vKpxT2wNarp1FbZWUWBl7Epsw3BJnTntk6P+uF3d1FcJjexZn01nDMAn7SiyMnkUSMBNspnFYHYfyCz35kdvJj37yPc8jBrhlWuiHEYaGbi3WtcdutKPqbb+3IrA18sjT72B6dCunS/ClhEvDCluaY1/N3ZPxeGCv37lzfrLWPak7vCIwEw7rsjjFqxnnwj8tvd7tAbFDKNx0NKP3uF/7aGuoMNy8+wQFQbR1MbFZaTiJYhMIgnjzOaGw++hoK1xCka8/F05cJBJi7cwSkouRpAXbs4GQy4GkpqYKj+7JyPB4XZgabpariWf77NAD+yCfsJGXbW8lgZATQYikCp8SwiMVEdi2oc8OhLWUbvbLa3/xJBKIwGBHgRCeMjs2LhsZZN9ghzye3/anP/LQTvnQztTugoL169cXFBR0C59yEjnhpTexrhdzxLZd0Rcd++TmoO7149911DiwR42OrUbCzca6Xci37fqOMwOR8YmJnY6amBgfnyVyIqkPu7Lg1vebXf/hqV1kx8TO2toOqNqgnRNBarVcPdval6/Ok5Cb5zeiEDUPXo2P1tau3uuo1bVBaCpGHvo886dv/SvaRaJv/uUDnhHG8zbywZjD4/audtTeuP+a1XIe/wAf9qmJn3//d5VOUnlB5b0RtvEPJIvyotEHcjpWz5pnjPKLX4XdrEkOyeTx3vj7ryQEIoRE2fQBLzMkuU2r1ClrbvPU5lPVTtERblbzbucpdTqlMk+y/9JfP9PeRoSvzfZeKanRakXZd7z7Oy+E8NRGZ0wHB6YRckGpGstXgepMlIzpal6Y4ZiTB656i7S67Kvej0AFi7R3ecQp52ROEby7naKx+vv36xsqVLqBz6ZV2gMzHP6AKiUle1/wI67q1x5+j/gYYjo+vnhJoq3Y8kp9/ebN9ffrz1SoevJ1Fyo5h5XZwcEp3lAuUyaSVD7jmPuTybr+OhBAoKanG3rOiDpDOHk6VVlwisMg5Y1+/pyW+Ye4uJ/xwyrq6pwhqBoaenrO6HRpnDCdrr8sJcWFnNWU9lWR/5rEHzXVPTEf0jDd0wOHIZET3Tmga9uHkLdLwd/nX3vsH3V1SMyG1NdPT5/JV4l02rucmcxkpXZAlN1/tQxIChqfEhwcfP73ryGB2qpHR2wzTF6k0w1oJUOw+kRmSNqAVqsTtWXvu4rmlRJcdudOUxOIJ15Boxvy8x3DlVqRhE+4LrHKNSvDOrWw/CJVW3Z//z6oLVvGxsbyK1RotFKrHciThPA/JVhfR82V0QckibpOJZTOVQPwZqAm7PD+jZVDxEO/wBNDlfw1ISslaWF5eW15iWHJkrv7ozNfIFiDvhFgAFty6pvJ5q+bAAAAAElFTkSuQmCC" alt="" class="waiter"><span class="waiter" >客服:小小</span></li>\n' +

        '</ul>' +
        '</div>';
    var newchild = document.createElement("div");
    newchild.innerHTML = html;
    body.appendChild(newchild)

}



function link() {
    //加载对话框
    var charframe = document.getElementById("charframe");
    if (charframe) {
        return false
    }

    var chat = document.getElementsByClassName("chat");
    log(chat)
    var newiframe = document.createElement("div");
    newiframe.innerHTML = '<iframe id="charframe" src="http://c.com/chat/" scrolling="no"></iframe>';
    chat[0].appendChild(newiframe)
    console.log(document.getElementsByTagName("iframe").src)

}

function closeChat() {
    var x=document.getElementById("charframe")
    log(x)
    x.remove(x[0])
}

function openWin() {
    var url='http://c.com/chat';                             //转向网页的地址;
    var name='add';                            //网页名称，可为空;
    var iWidth=720;                          //弹出窗口的宽度;
    var iHeight=600;                         //弹出窗口的高度;
    //获得窗口的垂直位置
    var iTop = (window.screen.availHeight - 30 - iHeight) / 2;
    //获得窗口的水平位置
    var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;
    window.open(url, name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');
    // window.open("AddScfj.aspx", "newWindows", 'height=100,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
}


//基础函数

/**
 * 动态加载css脚本
 * @param {string} cssText css样式
 */
function loadStyleString(cssText) {
    var style = document.createElement("style");
    style.type = "text/css";
    try {
        // firefox、safari、chrome和Opera
        style.appendChild(document.createTextNode(cssText));
    } catch (ex) {
        // IE早期的浏览器 ,需要使用style元素的stylesheet属性的cssText属性
        style.styleSheet.cssText = cssText;
    }
    document.getElementsByTagName("head")[0].appendChild(style);
}

//处理class
function hasClass(element, className) {
    var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
    return element.className.match(reg);
}

function addClass(element, className) {
    if (!this.hasClass(element, className)) {
        element.className += " " + className;
    }
}

function removeClass(element, className) {

    if (hasClass(element, className)) {
        var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
        element.className = element.className.replace(reg, ' ');
    }
}

function log(e) {
    return console.log(e)
}