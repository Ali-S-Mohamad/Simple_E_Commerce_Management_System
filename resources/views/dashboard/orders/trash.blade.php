@extends('layouts.dashboard')

@section('title', 'Trashed Orders')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
</div>

    {{-- <x-alert type="success" />
    <x-alert type="info" /> --}}

    <form action="{{ URL::current() }}" method="get" class="mb-4 d-flex justify-content-between">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="mx-2 form-control">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'pending')>Active</option>
            <option value="draft" @selected(request('status') == 'shipped')>Draft</option>
        </select>
        <button class="mx-2 btn btn-dark">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Status</th>
                <th>Price</th>
                <th>User</th>
                <th>Created At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td><img src="{{ asset('storage/' . $order->product->image) }}" alt="" height="50"></td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <td>
                            <form action="{{ route('dashboard.orders.restore', $order->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.orders.force-delete', $order->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No Orders defined</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $orders->withQueryString()->links() }}
@endsection
