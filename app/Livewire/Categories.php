<?php

namespace App\Livewire;

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class Categories extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $categories = [];
    public $category = [];
    public $isEdit = false;
    public $title = 'Add New Category';
    public $shouldCloseModal = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'categories.*.name' => 'required|string|max:255',
        'categories.*.description' => 'required|string|max:1000',
        'category.name' => 'required|string|max:255',
        'category.description' => 'required|string|max:1000',
    ];

    public function mount()
    {
        $this->resetFields();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->title = 'Add New Category';
        $this->categories = [['name' => '', 'description' => '']];
        $this->category = ['name' => '', 'description' => ''];
        $this->isEdit = false;
    }

    public function addForm()
    {
        $this->categories[] = ['name' => '', 'description' => ''];
    }

    public function removeCategories($key)
    {
        unset($this->categories[$key]);
        $this->categories = array_values($this->categories);
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->validate([
                'category.name' => 'required|string|max:255',
                'category.description' => 'required|string|max:1000',
            ]);

            $category = $this->category;
            Category::updateOrCreate(
                ['id' => $category['id']],
                ['name' => $category['name'], 'description' => $category['description']]
            );
            session()->flash('message', 'Category Successfully Updated.');
        } else {
            $this->validate([
                'categories.*.name' => 'required|string|max:255',
                'categories.*.description' => 'required|string|max:1000',
            ]);

            foreach ($this->categories as $category) {
                Category::create([
                    'name' => $category['name'],
                    'description' => $category['description']
                ]);
            }
            session()->flash('message', 'Category Successfully Added.');
        }

        $this->resetFields();
        $this->shouldCloseModal = true;
        $this->dispatch('close-modal');

        return redirect('/kategori');
    }

    public function edit($id)
    {
        $this->title = 'Edit Category';
        $category = Category::findOrFail($id);
        $this->category = ['id' => $id, 'name' => $category->name, 'description' => $category->description];
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Category::find($id)->delete();
    }

    public function cancel()
    {
        $this->resetFields();
        if ($this->isEdit) {
            $this->reset();
        }
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $categories_read = Category::where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.categories', ['categories_read' => $categories_read]);
    }
}
