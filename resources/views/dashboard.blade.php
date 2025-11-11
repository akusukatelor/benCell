@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Total Produk -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $productsCount ?? 0 }}</h3>
          <p>Total Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-box"></i>
        </div>
      </div>
    </div>

    <!-- Pemasukan Bulan Ini -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>Rp {{ number_format($incomeThisMonth ?? 0,0,',','.') }}</h3>
          <p>Pemasukan Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fas fa-wallet"></i>
        </div>
      </div>
    </div>

    <!-- Pengeluaran Bulan Ini -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>Rp {{ number_format($expenseThisMonth ?? 0,0,',','.') }}</h3>
          <p>Pengeluaran Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fas fa-credit-card"></i>
        </div>
      </div>
    </div>

    <!-- Pesanan Service Terbaru -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $recentService->count() ?? 0 }}</h3>
          <p>Pesanan Service Terbaru</p>
        </div>
        <div class="icon">
          <i class="fas fa-tools"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Bisa ditambahkan tabel ringkasan service terbaru -->
  <div class="row mt-4">
  <!-- Left: Chart Penjualan & Servis -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Tren Penjualan & Servis (6 bulan)</h3>
        <span class="text-muted">Estimasi omzet next month: <strong>Rp {{ number_format($predNextMonth,0,',','.') }}</strong></span>
      </div>
      <div class="card-body">
        <canvas id="salesChart" style="height:260px"></canvas>
        <div class="mt-3 text-sm text-gray-600 text-center">
@php
    $lastProfit = end($profitAmount); // laba/rugi bulan ini
    $diff = $predNextProfit - $lastProfit;

    if ($lastProfit != 0) {
        $percent = ($diff / abs($lastProfit)) * 100;
    } else {
        // kalau bulan ini nol, prediksi positif 100%, negatif -100%
        $percent = $diff >= 0 ? 100 : -100;
    }
@endphp

@if($predPercent > 0)
    📈 <strong>Prediksi:</strong> Laba bulan depan diperkirakan naik sekitar 
    <strong>{{ round($predPercent, 1) }}%</strong>.
@elseif($predPercent < 0)
    📉 <strong>Prediksi:</strong> Laba bulan depan diperkirakan turun sekitar 
    <strong>{{ round(abs($predPercent), 1) }}%</strong>.
@else
    ➖ <strong>Prediksi:</strong> Laba bulan depan diperkirakan stabil dibanding bulan ini.
@endif


  </div>
      </div>
    </div>

    <div class="card mt-3 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h3 class="card-title mb-0">Detail Penjualan Bulanan</h3>
    </div>

    <style>
        /* Modern table style */
        .table-modern th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 14px;
        }

        .table-modern td, .table-modern th {
            padding: 14px 12px !important;
            vertical-align: middle !important;
        }

        .table-modern tbody tr:hover {
            background: #f1f5f9 !important;
        }

        /* Membatasi lebar kolom agar tabel tidak melebar */
        .table-modern td {
            max-width: 180px;
            word-break: break-word;
            white-space: normal;
        }
    </style>

    <div class="card-body p-0">
        <table class="table table-modern table-hover mb-0">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Omzet</th>
                    <th>Laba / Rugi</th>
                    <th class="text-center">Transaksi</th>
                    <th class="text-center">Servis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($months as $i => $m)
                <tr>
                    <td class="fw-semibold">{{ $m }}</td>

                    <td>Rp{{ number_format($salesAmount[$i], 0, ',', '.') }}</td>

                    <td class="{{ $profitAmount[$i] < 0 ? 'text-danger fw-semibold' : 'text-success fw-semibold' }}">
                        Rp{{ number_format($profitAmount[$i], 0, ',', '.') }}
                    </td>

                    <td class="text-center">{{ $salesCount[$i] }}</td>
                    <td class="text-center">{{ $serviceCount[$i] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

  </div>

  <!-- Right: Insights -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Top Produk Terlaris</h3></div>
      <div class="card-body">
        <ul class="list-group">
          @forelse($topProducts as $p)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong>{{ $p['name'] }}</strong>
              </div>
              <span class="badge badge-primary badge-pill">{{ $p['total_qty'] }}</span>
            </li>
          @empty
            <li class="list-group-item">Belum ada data produk</li>
          @endforelse
        </ul>
      </div>
    </div>
   <div class="card mt-3">
    <div class="card-header"><h3 class="card-title">Status Stock Produk</h3></div>
    <div class="card-body">
        <ul class="list-group">
            @forelse($statusProducts as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>{{ $p['name'] }}</strong>
                    <span class="badge rounded-circle text-white" 
                          style="background-color: {{ $p['color'] == 'danger' ? '#dc3545' : '#ffc107' }}; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                        {{ $p['stock'] }}
                    </span>
                </li>
            @empty
                <li class="list-group-item">Semua produk aman (stok > 3)</li>
            @endforelse
        </ul>
    </div>
</div>




    <div class="card mt-3">
      <div class="card-header"><h3 class="card-title">Masalah Servis Terbanyak</h3></div>
      <div class="card-body">
        <ul class="list-group">
          @forelse($topServiceProblems as $tp)
            <li class="list-group-item d-flex justify-content-between">
              <strong><span class="text-truncate" style="max-width:200px">{{ $tp->problem }}</span></strong>
              <span class="badge badge-primary badge-pill">{{ $tp->cnt }}</span>
            </li>
          @empty
            <li class="list-group-item">Belum ada data servis</li>
          @endforelse
        </ul>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header"><h3 class="card-title">Quick Actions</h3></div>
      <div class="card-body">
        <a href="{{ route('service-orders.create') }}" class="btn btn-block btn-outline-primary mb-2">Tambah Service Order</a>
        <a href="{{ route('transactions.create') }}" class="btn btn-block btn-primary">Tambah Transaksi</a>
      </div>
    </div>  
  </div>
</div>

      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const months = @json($months);
    const amounts = @json($salesAmount);
    const profitAmount = @json($profitAmount ?? []); 
    const counts = @json($salesCount);
    const serviceCounts = @json($serviceCount);


    const ctx = document.getElementById('salesChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37,99,235,0.4)');
    gradient.addColorStop(1, 'rgba(37,99,235,0.05)');
 
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    type: 'line',
                    label: 'Omzet (Rp)',
                    data: amounts,
                    yAxisID: 'y',
                    tension: 0.3,
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    fill: true,
                },
                {
                    type: 'bar',
                    label: 'Profit / Rugi (Rp)',
                    data: profitAmount,
                    yAxisID: 'y',
                    backgroundColor: profitAmount.map(value => value >= 0 ? '#22c55e' : '#ef4444'), // hijau = laba, merah = rugi
                },
                {
                    type: 'line',
                    label: 'Prediksi Laba (bulan depan)',
                    data: [...profitAmount, {{ $predNextProfit }}],
                    borderDash: [10,5],
                    borderColor: '#16a34a',
                    tension: 0.4,
                    fill: false,
                },
                {
                    type: 'bar',
                    label: 'Transaksi',
                    data: counts,
                    yAxisID: 'y1',
                    backgroundColor: '#93c5fd',
                },
                {
                    type: 'bar',
                    label: 'Service',
                    data: serviceCounts,
                    yAxisID: 'y1',
                    backgroundColor: '#a7f3d0',
                }
            ]
        },
        options: {
            interaction: { mode: 'index', intersect: false },
            stacked: false,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });
});
</script>
@endpush


@endsection