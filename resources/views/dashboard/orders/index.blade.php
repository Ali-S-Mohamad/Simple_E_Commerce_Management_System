@extends('layouts.dashboard')

@section('title', 'Orders')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Orders</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('dashboard.orders.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
</div>

    {{-- <x-alert type="success" />
    <x-alert type="info" /> --}}

    <form action="{{ URL::current() }}" method="get" class="mb-4 d-flex justify-content-between">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="mx-2 form-control">
            <option value="">All</option>
            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
            <option value="shipped" @selected(request('status') == 'shipped')>Shipped</option>
            <option value="delivered" @selected(request('status') == 'delivered')>Delivered</option>
        </select>
        @php
            $users = App\Models\User::customer()->get();
        @endphp
        <select name="user" class="mx-2 form-control">
            <option value="">All</option>
            @foreach ($users as $user )
                <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
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
                        <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post">
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
    {{-- {{ $orders->withQueryString()->links() }} --}}
@endsection
