<div class="field">
    <label class="label"> {{$label}} </label>
    <div class="control">
        <input class="input" 
            name="{{$name}}" id="{{$name}}" type="{{$type ?? 'text' }}" 
            placeholder="{{$placeholder ?? ''}}" value="{{old($name)}}">
    </div>
        
    @if ($errors->has($name))
        <p class="help is-danger">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>