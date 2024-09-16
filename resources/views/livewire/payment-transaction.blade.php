<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-header my-3">
                <h4>Pembayaran untuk Transaksi {{ $transaction->customer_name }}</h4>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="processPayment">
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" id="total" class="form-control" value="{{ $total }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="bayar" class="form-label">Bayar</label>
                        <input type="number" id="bayar" class="form-control" wire:model.live="bayar" required min="{{ $total }}">
                    </div>
                    <div class="mb-3">
                        <label for="kembalian" class="form-label">Kembalian</label>
                        <input type="text" id="kembalian" class="form-control" value="{{ $kembalian }}" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>