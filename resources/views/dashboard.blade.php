@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
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
    <!-- Tambah box lain: pemasukan, pengeluaran, service masuk -->
  </div>
</div>
@endsection
