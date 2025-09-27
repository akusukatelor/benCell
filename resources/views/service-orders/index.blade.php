@extends('layouts.app')

@section('title', 'Service Orders')

@section('content')
<div class="container">
    <h1 class="mb-3">Daftar Service Order</h1>
    <a href="{{ route('service-orders.create') }}" class="btn btn-primary mb-3">Tambah Service Order</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Nomor HP</th>
                <th>Device</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Estimasi Biaya</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($serviceOrders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_phone }}</td>
                <td>{{ $order->device }}</td>
                <td>{{ $order->problem }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ ucfirst($order->estimated_cost) }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('service-orders.edit', $order) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('service-orders.destroy', $order) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Belum ada service order</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
