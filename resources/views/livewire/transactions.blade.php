<div class="row justify-content-center mt-3"> 
	<div class="col-md-12">
        <div class="card mt-5">
            <div wire:ignore.self class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transactionModalLabel">{{ $title }}</h5>
                                <button type="button" class="btn-close" wire:click="cancel" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form wire:submit.prevent="save">
                                    <!-- Transaction Code -->
                                    <div class="mb-3">
                                        <label for="transaction_code" class="form-label">Transaction Code</label>
                                        <input type="text" wire:model.defer="transaction.transaction_code" class="form-control" readonly>
                                        @error('transaction.transaction_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" wire:model.defer="transaction.customer_name" class="form-control">
                                        @error('transaction.customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    @if($isEdit)
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select wire:model.defer="transaction.status" class="form-select">
                                            <option value="Pending">Pending</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Canceled">Canceled</option>
                                        </select>
                                        @error('transaction.status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @else
                                        <input type="hidden" wire:model.defer="transaction.status" value="pending">
                                    @endif

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success me-2">Save</button>
                                        <button type="button" wire:click="cancel" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div wire:loading class="text-primary mt-2">Processing...</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Add Transaction Button -->
            <div class="card-header">
                Trasactions List
                <button class="btn btn-primary float-end" wire:click="resetFields" data-bs-toggle="modal" data-bs-target="#transactionModal">
                    Add New Transaction
                </button>
            </div>
            <div class="card-body">
          
                <!-- Transactions Table -->
                <table class="table table-striped table-bordered">
                    <form>
                    <input type="text" wire:model.live="searchTerm" class="form-control mb-3" placeholder="Search Transactions..." />
                </form>

                    <thead>
                        <tr>
                            <th>Transaction Code</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                                <td>{{ $transaction->customer_name }}</td>
                                <td>Rp.{{ number_format($transaction->total_amount) }}</td>
                                <td>Rp.{{ number_format( $transaction->bayar) }}</td>
                                <td>Rp.{{ number_format( $transaction->kembalian) }}</td>
                                <td>{{ $transaction->status }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transactionModal"  wire:click="edit({{ $transaction->id }})">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus_transactions({{ $transaction->id }})"><i class="bi bi-trash"></i> Delete</button>
                                    <a href="{{ route('transaction.details', $transaction->id) }}" class="btn btn-primary btn-sm">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                 <div class="d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hapus_transactions(hapus_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mx-4',
                cancelButton: 'btn btn-danger mx-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Hapus Data Transaction',
            text: "Data kamu tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batal!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', hapus_id);
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