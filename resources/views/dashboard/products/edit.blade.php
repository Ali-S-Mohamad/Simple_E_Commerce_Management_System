@extends('layouts.dashboard')

@section('title', 'Edit Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
    <li class="breadcrumb-item active">Edit Product </li>
@endsection

@section('content')

    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @php
            $categories = App\Models\Category::all();
        @endphp

        @include('dashboard.products._form',[
            'button_label' => 'Update'
        ])
    </form>

@endsection
