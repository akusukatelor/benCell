@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-3">Daftar Transaksi</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipe</th>
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
                <td>
                    <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-warning' }}">
                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td>{{ $transaction->product->name ?? '-' }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->formatted_total }}</td> {{-- Uses new accessor --}}
                {{-- Alternative without accessor: <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td> --}}
                <td>{{ $transaction->date->format('d/m/Y H:i') }}</td> {{-- Use custom date field --}}
                <td>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline ms-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- Pagination (add to controller: ->paginate(10) instead of ->get() --}}
    {{ $transactions->links() }}
</div>
@endsection