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
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">5 Pesanan Service Terbaru</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Customer</th>
                <th>Device</th>
                <th>Status</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentService as $service)
              <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->customer_name }}</td>
                <td>{{ $service->device }}</td>
                <td>{{ ucfirst($service->status) }}</td>
                <td>{{ $service->created_at->format('d-m-Y') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
