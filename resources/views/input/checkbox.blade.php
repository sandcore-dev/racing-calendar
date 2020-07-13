<div class="form-group row">
    <div class="col-sm-6 offset-sm-4 checkbox">
    	<label>
	        <input type="hidden" name="{{ $field }}" value="0">
	        <input class="{{ $errors->has($field) ? 'is-invalid' : '' }}" type="checkbox" name="{{ $field }}" value="1"{{ old($field, (isset($value) ? $value : '')) == 1 ? ' checked' : '' }}>
        	{{ $label }}
        </label>

        @if ($errors->has($field))
            <span class="is-invalid">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
        @endif
    </div>
</div>

