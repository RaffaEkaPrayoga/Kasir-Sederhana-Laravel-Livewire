<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card mt-2">
            
            <div class="card-header">
                Detail Transactions
            </div>
            <div class="card-body">
                <!-- Add New Product Form -->
        <form wire:submit.prevent="save">
            @foreach($products as $key => $product)
                <div class="row mb-3">
                    <!-- Product Selection -->
                    <div class="col-md-2">
                        <label for="product_id_{{ $key }}" class="form-label">Product</label>
                        <select wire:model.live="products.{{ $key }}.product_id" class="form-select">
                            <option value="">Select Product</option>
                            @foreach($productsList as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                        @error('products.' . $key . '.product_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Stok Produk -->
                    <div class="col-md-2">
                        <label for="stok_{{ $key }}" class="form-label">Stok Produk</label>
                        <input type="number" wire:model.live="products.{{ $key }}.stok" class="form-control" readonly>
                        @error('products.' . $key . '.stok')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Unit Price -->
                    <div class="col-md-2">
                        <label for="unit_price_{{ $key }}" class="form-label">Unit Price</label>
                        <input type="number" wire:model.live="products.{{ $key }}.unit_price" class="form-control" readonly>
                        @error('products.' . $key . '.unit_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Quantity -->
                    <div class="col-md-2">
                        <label for="quantity_{{ $key }}" class="form-label">Quantity</label>
                        <input type="number" wire:model.live="products.{{ $key }}.quantity" class="form-control" min="1">
                        @error('products.' . $key . '.quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Subtotal -->
                    <div class="col-md-2">
                        <label for="subtotal_{{ $key }}" class="form-label">Subtotal</label>
                        <input type="number" wire:model.live="products.{{ $key }}.subtotal" class="form-control" readonly>
                        @error('products.' . $key . '.subtotal')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Remove Button -->
                    <div class="col-md-2 mt-4">
                        <button type="button" class="btn btn-danger mt-2" wire:click="removeProduct({{ $key }})">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach


            @if ($transactionStatus == 'Pending')        
                <!-- Add New Product Button -->
                <button type="button" class="btn btn-warning mb-3 me-3" wire:click="addForm">
                    <span class="text-white">Add New Product</span>
                </button>


                <!-- Submit Button -->
                <button type="submit" class="btn btn-success mb-3 px-5">
                    Save
                </button>
            @endif
            <div wire:loading class="text-primary mt-2">Processing...</div>
        </form>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                            @if ($transactionStatus == 'Pending')
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactionDetails as $detail)
                            <tr>
                                <td>{{ optional($detail->product)->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp.{{ number_format( $detail->unit_price ) }}</td>
                                <td>Rp.{{ number_format( $detail->subtotal ) }}</td>
                            <td>
                                    @if ($transactionStatus == 'Pending')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus_details({{ $detail->id }})"><i class="bi bi-trash"></i> Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No products found for this transaction.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


 <div class="float-end mt-3 me-5">                
<h5>Total Amount : Rp.{{ number_format( $totalSubtotal) }}</h5>
                    @if ($transactionStatus == 'Pending')
                        <!-- Payment Button -->
                        <a href="{{ route('payment-page', ['transactionId' => $transactionId]) }}" class="btn btn-primary">Bayar</a>
                    @endif
                </div>



                <div class="float-start mt-4 mx-3">
                     <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>  
    </div>
</div>

<script>
    function hapus_details(hapus_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mx-4',
                cancelButton: 'btn btn-danger mx-4'
            },
            buttonsStyling: false
        });


        swalWithBootstrapButtons.fire({
            title: 'Hapus Data Produk',
            text: "Data kamu tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batal!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('removeProductDetail'    , hapus_id);
                swalWithBootstrapButtons.fire(
                    'Hapus!',
                    'Transaction Successfully Deleted and stock returned if completed.',
                    'success'
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Batal',
                    'Data kamu masih aman :)',
                    'error'
                );
            }
        });
    }
</script>
