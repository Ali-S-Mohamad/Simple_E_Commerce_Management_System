@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('dashboard.products.create') }}" class="mr-2 btn btn-sm btn-outline-primary">Create</a>
    <a href="{{ route('dashboard.products.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
</div>

    {{-- <x-alert type="success" />
    <x-alert type="info" /> --}}

    <form action="{{ URL::current() }}" method="get" class="mb-4 d-flex justify-content-between">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="mx-2 form-control">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="draft" @selected(request('status') == 'draft')>Draft</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="mx-2 btn btn-dark">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                    <td><a href="{{ route('dashboard.products.show',$product->id) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No Products defined</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $products->withQueryString()->links() }}
@endsection
