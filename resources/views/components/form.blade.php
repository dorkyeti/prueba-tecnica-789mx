<form method="POST" 
    {{-- Si existe la acción, dibujarla --}} 
    @isset($action) action="{{ $action }}" @endisset
    {{-- Si existe el autocompletado, dibujarlo --}}
    @isset($autocomplete) autocomplete="{{ $autocomplete ? 'on' : 'off' }}" @endisset
    {{-- Si existe el id, dibujarlo --}} 
    @isset($id) id="{{ $id }}" @endisset>
    {{-- Input de CSRF --}}
    @csrf

    {{-- Metodo HTTP --}}
    @if (isset($method) && $method != 'POST')
        @method($method)
    @endif

    {{ $slot }}
</form>
