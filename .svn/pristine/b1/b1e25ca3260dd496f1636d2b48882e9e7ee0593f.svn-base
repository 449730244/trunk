<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        <div class="input-group" style="width: 100%;">
        <input {!! $attributes !!} id="{{$id}}" name="{{$name}}" data-toggle="city-picker" class="form-control" style="position: absolute;" readyonly  >
        </div>
        @include('admin::form.help-block')
    </div>
</div>