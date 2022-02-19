<label for="{{$field}}" class="form-label">{{$label}}</label>
<textarea name="{{$field}}" id="{{$field}}" cols="20" rows="5" class="form-control"
          placeholder="{{$placeholder}}">{{old($field, $value)}}</textarea>
@error("$field")
<span class="text-danger">{{$message}}</span>
@enderror
