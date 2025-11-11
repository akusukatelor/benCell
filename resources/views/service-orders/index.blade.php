@extends('layouts.app')

@section('title', 'Service Orders')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">🛠️ Daftar Service Order</h1>
        <a href="{{ route('service-orders.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Service Order
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Nomor HP</th>
                            <th>Device</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th>Estimasi Biaya</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ $order->device }}</td>
                                <td style="white-space: normal;">{{ $order->problem }}</td>

                                <td>
                                    @php
                                        $color = match($order->status) {
                                            'pending' => 'warning',
                                            'ongoing' => 'primary',
                                            'done' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'success',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }} px-3 py-2">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td>Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

                                <td class="text-center">
                                    <a href="{{ route('service-orders.edit', $order) }}" 
                                       class="btn btn-sm btn-warning me-1 shadow-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('service-orders.destroy', $order) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Yakin hapus service order ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    Belum ada service order.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $serviceOrders->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('styles')
<style>
    /* Hover */
    table.table tbody tr:hover {
        background-color: #f8f9fa !important;
        transition: 0.2s ease;
    }

    /* Pertegas border agar tetap modern */
    table.table-bordered > :not(caption) > * > * {
        border-color: #dee2e6 !important;
    }

    /* Biar teks panjang membungkus */
    td {
        white-space: nowrap;
    }

    /* Khusus kolom keluhan biar wrap */
    td:nth-child(5) {
        white-space: normal !important;
    }

    .card {
        border-radius: 14px;
    }
</style>
@endpush

@endsection
