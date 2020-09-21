<div class="field">
    <label class="label"> {{$label}} </label>
    <div class="control">
        <input class="input" 
                name="{{$name}}" id="{{$name}}" type="{{$type ?? 'text' }}" 
                placeholder="{{$placeholder ?? ''}}" 
                @isset(($object->{$name})) value="{{ old($name) ? old($name) : $object->{$name} }}"
                @else value="{{old($name)}}" @endisset>
    </div>
        
    @if ($errors->has($name))
        <p class="help is-danger">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>