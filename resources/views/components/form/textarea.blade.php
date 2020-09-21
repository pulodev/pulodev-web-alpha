<div class="field">
    <label class="label"> {{$label}} </label>
    <div class="control">
        <textarea class="textarea" name="{{$name}}" id="{{$name}}" placeholder="{{$placholder ?? ''}}">{{old($name)}}</textarea>
    </div>

      @if ($errors->has($name))
        <p class="help is-danger">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>