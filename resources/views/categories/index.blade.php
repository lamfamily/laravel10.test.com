@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>分类列表</span>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">添加分类</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="category-tree">
                        @include('categories.partials.category-item', ['categories' => $categories])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
