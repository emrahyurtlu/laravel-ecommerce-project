<div class="form-check mt-4">
    <input class="form-check-input"
           type="checkbox"
           id="{{$field}}"
           name="{{$field}}"
           value="1"
           {{$checked ? "checked" : ""}}>
    <label class="form-check-label" for="{{$field}}">
        {{$label}}
    </label>
</div>
