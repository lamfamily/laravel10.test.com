@foreach($categories as $category_item)
<option value="{{ $category_item->id }}" {{ isset($selected) && $selected == $category_item->id ? 'selected' : '' }}>
    {{ str_repeat('— ', $category_item->depth) }}{{ $category_item->name }}
</option>
@if($category_item->children->isNotEmpty())
@include('categories.partials.category-options', [
'categories' => $category_item->children,
'selected' => $selected ?? null
])
@endif
@endforeach
