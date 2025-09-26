@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-3">Daftar Transaksi</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->product->name ?? '-' }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>Rp{{ number_format($transaction->total,0,',','.') }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Belum ada transaksi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
