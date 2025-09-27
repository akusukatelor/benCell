@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-3">Tambah Transaksi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
            <label for="type">Tipe Transaksi</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Pilih Tipe</option>
                <option value="income">Income (Penjualan - Kurangi Stok)</option>
                <option value="expense">Expense (Pembelian - Tambah Stok)</option>
            </select>
        </div>

        <div class="form-group mb-2">
            <label for="product_name">Produk</label>
            <select name="product_name" id="product_name" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->name }}" 
                            data-cost-price="{{ $product->cost_price ?? 0 }}" 
                            data-sell-price="{{ $product->sell_price ?? 0 }}">
                        {{ $product->name }} 
                        (Cost: Rp {{ number_format($product->cost_price ?? 0, 0, ',', '.') }} | 
                         Sell: Rp {{ number_format($product->sell_price ?? 0, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2">
            <label for="quantity">Jumlah (Quantity)</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required min="1" value="1">
        </div>

        <div class="form-group mb-2">
            <label for="amount" id="amount-label">Jumlah Uang (Amount)</label>
            <input type="number" name="amount" id="amount" class="form-control" required min="0" step="0.01" readonly>
            <small class="form-text text-muted" id="amount-help">Otomatis dihitung berdasarkan harga x quantity.</small>
        </div>

        <input type="hidden" name="date" value="{{ now()->format('Y-m-d H:i:s') }}">

        <div class="form-group mb-2">
            <label for="note">Catatan (Opsional)</label>
            <textarea name="note" id="note" class="form-control" rows="3" placeholder="Masukkan catatan tambahan..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    function calculateAmount() {
        const typeSelect = document.getElementById('type');
        const productSelect = document.getElementById('product_name');
        const quantityInput = document.getElementById('quantity');
        const amountInput = document.getElementById('amount');
        const amountLabel = document.getElementById('amount-label');
        const amountHelp = document.getElementById('amount-help');

        const type = typeSelect.value;
        const selectedOption = productSelect.selectedOptions[0];
        const quantity = parseInt(quantityInput.value || 0);

        let price = 0;

        if (type === 'income' && selectedOption) {
            price = parseFloat(selectedOption.getAttribute('data-sell-price') || 0);
            amountLabel.textContent = 'Harga Jual';
            amountHelp.textContent = 'Otomatis dihitung: Harga Jual x Quantity';
        } else if (type === 'expense' && selectedOption) {
            price = parseFloat(selectedOption.getAttribute('data-cost-price') || 0);
            amountLabel.textContent = 'Harga Beli';
            amountHelp.textContent = 'Otomatis dihitung: Harga Beli x Quantity';
        } else {
            amountLabel.textContent = 'Jumlah Uang (Amount)';
            amountHelp.textContent = 'Pilih tipe dan produk untuk kalkulasi otomatis.';
        }

        if (price > 0 && quantity > 0) {
            const total = price * quantity;
            amountInput.value = total; // angka murni tanpa format
        } else {
            amountInput.value = '';
        }
    }

    // Event listener
    document.getElementById('type').addEventListener('change', calculateAmount);
    document.getElementById('product_name').addEventListener('change', calculateAmount);
    document.getElementById('quantity').addEventListener('input', calculateAmount);

    // Strip format sebelum submit (jaga-jaga kalau ada manipulasi)
    document.querySelector('form').addEventListener('submit', function () {
        const amountInput = document.getElementById('amount');
        amountInput.value = parseFloat(amountInput.value.replace(/[^\d.]/g, '')) || 0;
    });

    // Jalankan saat halaman pertama kali load
    calculateAmount();
</script>

@endsection