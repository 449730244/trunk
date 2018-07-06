<form class="layui-form">
    <div id="create_group_box" style="margin:10px;">
        <div class="layui-form-item">
            <label class="layui-form-label">群名称</label>
            <div class="layui-input-block">
                <input name="title" lay-verify="title" autocomplete="off" placeholder="群名称" class="layui-input" type="text">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="check_user_list">
                <ul>
@foreach ($userlist as $user)
                    <li>
                        <img src="{{ $user->avatar ? '/uploads/'.$user->avatar : '/chat/img/avatar.png' }}" alt="">
                        <span>{{ $user->name }}</span>
                    </li>
@endforeach
                </ul>
            </div>
        </div>
    </div>
</form>