@extends('layouts.app')

@section('title', 'Edit Service Order')

@section('content')
<div class="container">
    <h1 class="mb-3">Edit Service Order</h1>
    <form action="{{ route('service-orders.update', $serviceOrder) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="form-group mb-2">
            <label>Nama Pelanggan</label>
            <input type="text" name="customer_name" value="{{ $serviceOrder->customer_name }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Nomor HP</label>
            <input type="text" name="customer_phone" value="{{ $serviceOrder->customer_phone }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Device</label>
            <input type="text" name="device" value="{{ $serviceOrder->device }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Keluhan</label>
            <input type="text" name="problem" value="{{ $serviceOrder->problem }}" class="form-control" required>
        </div>

        
        <div class="form-group mb-2">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending"  @selected($serviceOrder->status == 'pending')>Pending</option>
                <option value="proses"   @selected($serviceOrder->status == 'proses')>Proses</option>
                <option value="selesai"  @selected($serviceOrder->status == 'selesai')>Selesai</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Estimasi Biaya</label>
            <input type="number" name="estimated_cost" value="{{ $serviceOrder->estimated_cost }}" class="form-control" required>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
