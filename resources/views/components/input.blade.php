<?php
use Illuminate\Support\Str;

$input = Str::snake(Str::lower($name));

$name = Str::title($name);

$required ??= true;
$label ??= true;

?>
<div class="col form-group">
    @if ($label)
        <label for="{{ $input }}">{{ $nombre ?? $name }}</label>
    @endif

    <input 
        type="{{ $type ?? 'text' }}" 
        name="{{ $input }}" 
        id="{{ $input }}"
        value="{{ $valor ?? old($input) }}"
        @class([
            'form-control', 
            'form-control-plaintext' => isset($readonly) && $readonly, 
            'is-invalid' => $errors->has($input)
        ])
        @isset($attrs) @foreach ($attrs as $name => $attr) {{ $name }}="{{ $attr }}" @endforeach @endisset
        @readonly(isset($readonly) && $readonly) @required($required) 
    />
    <div class="invalid-feedback">
        @error($input)
            {{ $message }}
        @enderror
    </div>
</div>
