@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<h1 class="mb-3">Daftar Transaksi</h1>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    <form method="GET" action="{{ route('transactions.index') }}" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-secondary">Cari</button>
    </form>
</div>


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
                <th>Catatan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    @forelse($transactions as $transaction)
    <tr>
        <td>{{ $transaction->id }}</td>

        {{-- Tipe Transaksi --}}
        <td>
            @if($transaction->type === 'income')
                <span class="badge bg-success">Pemasukan Produk</span>
            @elseif($transaction->type === 'expense')
                <span class="badge bg-warning">Pengeluaran</span>
            @elseif($transaction->type === 'income_service')
                <span class="badge bg-info">Pemasukan Servis</span>
            @endif
        </td>

        {{-- Nama Produk / Customer (untuk servis) --}}
        <td>
            @if($transaction->type === 'income_service' && $transaction->serviceOrder)
                {{ $transaction->serviceOrder->customer_name }} (Service #{{ $transaction->service_order_id }})
            @else
                {{ $transaction->product->name ?? '-' }}
            @endif
        </td>

        <td>{{ $transaction->quantity }}</td>

        {{-- Total --}}
        <td>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>

        <td>{{ $transaction->note }}</td>
        <td>{{ $transaction->date->format('d/m/Y H:i') }}</td>
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
        <td colspan="8" class="text-center">Belum ada transaksi</td>
    </tr>
    @endforelse
</tbody>
    </table>
    
    {{-- Pagination (add to controller: ->paginate(10) instead of ->get()) --}}
   <div class="d-flex justify-content-center">
    {{ $transactions->links('pagination::bootstrap-5') }}
</div>

</div>
@endsection