<!-- Modal Structure -->
<div wire:ignore.self class="modal fade" id="categoriesModal" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" wire:click="cancel" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save">
                    <!-- Single categories Form for Edit -->
                    @if($isEdit)
                        <div class="mb-3">
                            <!-- categories Name -->
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" wire:model.defer="category.name" class="form-control"
                                   :class="{'is-invalid': errors['categories.name']}">
                            @error('categories.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- categories Description -->
                            <label for="description" class="form-label">Category Description</label>
                            <div wire:ignore x-data="{ {$categories['description']} }" x-init="
                                ClassicEditor.create($refs.editor)
                                    .then(newEditor => {
                                        editor = newEditor;
                                        editor.model.document.on('change:data', () => {
                                            @this.set('category.description', editor.getData());
                                        });
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    })
                            ">
                                <textarea x-ref="editor" class="form-control">{{ $category['description'] ?? '' }}</textarea>
                            </div>
                            @error('categories.description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <!-- Loop through categories for add mode -->
                        @foreach($categories as $key => $prod)
                            <div class="mb-3">
                                <!-- categories Name -->
                                <label for="name_{{ $key }}" class="form-label">Category Name</label>
                                <input type="text" wire:model.defer="categories.{{ $key }}.name" class="form-control"
                                       :class="{'is-invalid': errors['categories.{{ $key }}.name']}">
                                @error('categories.' . $key . '.name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- categories Description -->
                                <label for="description_{{ $key }}" class="form-label">Category Description</label>
                                <div wire:ignore x-data="{ {categories.*.$key.description} }" x-init="
                                    ClassicEditor.create($refs.editor_{{ $key }})
                                        .then(newEditor => {
                                            editor = newEditor;
                                            editor.model.document.on('change:data', () => {
                                                @this.set('categories.{{ $key }}.description', editor.getData());
                                            });
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        })
                                ">
                                    <textarea x-ref="editor_{{ $key }}" class="form-control">{{ $categories['description'] ?? '' }}</textarea>
                                </div>
                                @error('categories.' . $key . '.description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Remove Button -->
                                <button type="button" class="btn btn-danger mt-2" wire:click="removeCategories({{ $key }})">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    @endif

                    <!-- Conditional Add New categories Button -->
                    @if(!$isEdit)
                        <button type="button" class="btn btn-info mb-3" wire:click="addForm">
                            Add New categories
                        </button>
                    @endif

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

<!-- JavaScript for handling dynamic categories addition and removal -->
{{-- <script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('removeCategories', key => {
            // Implement the removal logic for categories with given key
            Livewire.dispatch('removeCategories', key);
        });
    });
</script> --}}
