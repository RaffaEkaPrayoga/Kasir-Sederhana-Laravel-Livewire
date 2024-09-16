<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @include('livewire.updateOrCreateCategories')

        <div class="card mt-5">
            <div class="card-header">
                Categories List
                <!-- Button to Open Modal -->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categoriesModal" wire:click="$refresh()" @click="categories=[{name: '', description: ''}]; initEditors();">
                    <i class="bi bi-plus-circle"></i> Add New categories
                </button>

            </div>
            <div class="card-body">
                <!-- Search Input -->
                <form>
                    <input type="text" wire:model.live="searchTerm" class="form-control mb-3" placeholder="Search categories..." />
                </form>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories_read as $categories)
                            <tr wire:key="{{ $categories->id }}">
                                <th scope="row">{{ ($categories_read->currentPage() - 1) * $categories_read->perPage() + $loop->iteration }}</th>
                                <td>{{ $categories->name }}</td>
                                <td>{!! $categories->description !!}</td>
                                <td>
                                    <button wire:click="edit({{ $categories->id }})" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus_category({{ $categories->id }})">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger"><strong>No categories Found!</strong></span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $categories_read->links() }}
                </div>
            </div>
        </div>
    </div>    
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapus_category(hapus_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mx-4',
                cancelButton: 'btn btn-danger mx-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Hapus Data Kata',
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
                    'Data kamu telah dihapus.',
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

@if (session()->has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('message') }}',
            });
        });
    </script>
@endif

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('set-editor-data', data => {
            const editorInstance = editorInstances[0]; // assuming single editor for edit
            if (editorInstance) {
                editorInstance.setData(data.description);
            }
        });
    });
</script>