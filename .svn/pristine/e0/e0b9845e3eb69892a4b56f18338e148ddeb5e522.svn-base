<div class="forward_box_list">
    <ul class="forward_box">
        @foreach ($groups as $group)
            <li data="group_{{$group->id}}"><img src="/chat/img/grouphead.png">
                <span>{{$group->name}}</span>
            </li>
        @endforeach
        @foreach ($users as $user)
            @if ($user->id != Auth::user()->id)
            <li data="user_{{$user->id}}"><img src="{{ avatar($user->avatar) }}" onerror="this.src='/chat/img/user.png'">
                <span>{{$user->name}}</span>
            </li>
            @endif
    @endforeach
    </ul>
    <p class="forward_selected"></p>
</div>
