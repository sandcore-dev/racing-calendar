<div class="form-group row">
    <label for="{{ $field }}" class="col-sm-4 col-form-label text-sm-right">{{ $label }}</label>

    <div class="col-sm-6">
        <select class="form-control{{ $errors->has($field) ? 'is-invalid' : '' }}" id="{{ $field }}" name="{{ $field }}">
            @foreach( $options as $option )
                <option value="{{ $option['id'] }}"{{ isset( $value ) && $option['id'] === $value ? ' selected' : '' }}>
                    {{ $option[isset( $option_label ) ? $option_label : 'name'] }}
                </option>
            @endforeach
        </select>

        @if ($errors->has($field))
            <span class="is-invalid">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
        @endif
    </div>
</div>
