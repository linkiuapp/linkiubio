<option value="">Todas las categorías</option>
@foreach($categories as $cat)
    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
        {{ ucfirst(str_replace('_', ' ', $cat)) }}
    </option>
@endforeach
