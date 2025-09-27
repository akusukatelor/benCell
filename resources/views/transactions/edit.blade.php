@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-3">Edit Transaksi</h1>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group mb-2">
            <label>Produk</label>
            <select name="product_id" class="form-control" required>
                @foreach($products as $product)
                  <option value="{{ $product->id }}" @if($transaction->product_id == $product->id) selected @endif>
                    {{ $product->name }}
                  </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Jumlah</label>
            <input type="number" name="quantity" value="{{ $transaction->quantity }}" class="form-control" required>
        </div>
       <div class="form-group mb-2">
            <label for="note">Catatan (Opsional)</label>
            <textarea name="note" id="note" class="form-control" rows="3" placeholder="Masukkan catatan tambahan..."></textarea>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
