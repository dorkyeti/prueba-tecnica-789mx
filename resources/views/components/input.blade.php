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
        class="@isset($readonly)form-control-plaintext @else form-control @endisset @error($input)is-invalid @enderror"
        @isset($attrs) @foreach ($attrs as $name => $attr) {{ $name }}="{{ $attr }}" @endforeach @endisset
        @isset($readonly) readonly @endisset @if ($required) required @endif />
    <div class="invalid-feedback">
        @error($input)
            {{ $message }}
        @enderror
    </div>
</div>
