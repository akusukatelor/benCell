@extends('layouts.app')

@section('title', 'Tambah Service Order')

@section('content')
<div class="container">
    <h1 class="mb-3">Tambah Service Order</h1>
    <form action="{{ route('service-orders.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label>Nama Pelanggan</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Nomor HP</label>
            <input type="text" name="customer_phone" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Keluhan</label>
            <input type="text" name="problem" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div class="form-group">
            <label for="device">Device</label>
            <input type="text" name="device" id="device" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Estimasi Biaya</label>
            <input type="number" name="estimated_cost" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
