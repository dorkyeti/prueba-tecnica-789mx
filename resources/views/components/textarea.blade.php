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

    <textarea id="{{ $input }}" rows="{{ $row ?? 3 }}"
        class="@isset($readonly)form-control-plaintext @else form-control @endisset @error($input) is-invalid @enderror"
        name="{{ $input }}" @isset($readonly) readonly @endisset
        @if ($required) required @endif></textarea>

    <div class="invalid-feedback">
        @error($input)
            {{ $message }}
        @enderror
    </div>
</div>
