<ul>
    @foreach($categories as $category)
    <li>
        {{ $category->name }}
        <div class="actions">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">编辑</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('确定要删除吗？')">删除</button>
            </form>
        </div>

        @if($category->children->isNotEmpty())
        @include('categories.partials.category-item', ['categories' => $category->children])
        @endif
    </li>
    @endforeach
</ul>
