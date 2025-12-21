@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">💳 Daftar Transaksi</h1>

        <a href="{{ route('transactions.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    {{-- Search --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <form method="GET" action="{{ route('transactions.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2"
                placeholder="Cari nama produk..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipe</th>
                            <th>Produk / Pelanggan</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Catatan</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>

                            {{-- Badge Tipe --}}
                            <td>
                                @switch($transaction->type)
                                    @case('income')
                                        <span class="badge bg-success px-3 py-2">Pemasukan Produk</span>
                                        @break
                                    @case('expense')
                                        <span class="badge bg-warning px-3 py-2">Pengeluaran</span>
                                        @break
                                    @case('income_service')
                                        <span class="badge bg-info px-3 py-2">Pemasukan Servis</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary px-3 py-2">Lainnya</span>
                                @endswitch
                            </td>

                            {{-- Nama Produk / Customer --}}
                            <td>
                                @if($transaction->type === 'income_service' && $transaction->serviceOrder)
                                    {{ $transaction->serviceOrder->customer_name }} 
                                    (Service #{{ $transaction->service_order_id }})
                                @else
                                    {{ $transaction->product->name ?? '-' }}
                                @endif
                            </td>

                            <td>{{ $transaction->product->category->name ?? '-' }}</td>
                            <td>{{ $transaction->quantity }}</td>

                            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>

                            <td style="white-space: normal;">{{ $transaction->note }}</td>

                            <td>{{ $transaction->date->format('d/m/Y H:i') }}</td>

                            <td class="text-center">
                                <a class="btn btn-sm btn-warning shadow-sm" 
                                    href="{{ route('transactions.edit', $transaction) }}">
                                    Edit
                                </a>

                                <form action="{{ route('transactions.destroy', $transaction) }}" 
                                      method="POST" class="d-inline ms-1">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger shadow-sm"
                                        onclick="return confirm('Yakin hapus transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Belum ada transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('styles')
<style>
    /* Hover row */
    table.table tbody tr:hover {
        background-color: #f8f9fa !important;
        transition: 0.2s ease;
    }

    /* Pertegas border tanpa membuatnya kasar */
    table.table-bordered > :not(caption) > * > * {
        border-color: #dee2e6 !important;
    }

    /* Kolom catatan wrap */
    td:nth-child(6) {
        white-space: normal !important;
    }

    .card {
        border-radius: 14px;
    }
</style>
@endpush

@endsection
