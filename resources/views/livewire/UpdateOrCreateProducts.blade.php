<!-- Modal Structure -->
<div wire:ignore.self class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productsModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" wire:click="cancel" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <!-- Product Name -->
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" wire:model.defer="product.name" class="form-control"
                               :class="{'is-invalid': errors['product.name']}">
                        @error('product.name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Product Description -->
                        <label for="description" class="form-label">Product Description</label>
                            <div wire:ignore x-data x-init="
                                ClassicEditor.create($refs.editor)
                                    .then(newEditor => {
                                        editor = newEditor;
                                        editor.model.document.on('change:data', () => {
                                            @this.set('product.description', editor.getData());
                                        });
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    })
                            ">
                                <textarea x-ref="editor" class="form-control">{{ $product['description'] ?? '' }}</textarea>
                            </div>
                        @error('product.description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        <!-- Product Quantity -->
                        <label for="quantity" class="form-label">Product Quantity</label>
                        <input type="number" wire:model.defer="product.quantity" class="form-control"
                               :class="{'is-invalid': errors['product.quantity']}">
                        @error('product.quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Product Price -->
                        <label for="price" class="form-label">Product Price</label>
                        <input type="number" step="0.01" wire:model.defer="product.price" class="form-control"
                               :class="{'is-invalid': errors['product.price']}">
                        @error('product.price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Product Category -->
                        <label for="category_id" class="form-label">Product Category</label>
                        <select wire:model.defer="product.category_id" class="form-select"
                                :class="{'is-invalid': errors['product.category_id']}">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product.category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">Save</button>
                        <button type="button" wire:click="cancel" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                    <div wire:loading class="text-primary mt-2">Processing...</div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
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