<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryManager extends Component
{
    public $name, $type = 'Pengeluaran', $categoryId = null;
    public $editing = false;
    public $for_recurring = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:Pemasukan,Pengeluaran',
        'for_recurring' => 'boolean',
    ];

    public function create()
    {
        $this->validate();

        Category::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'type' => $this->type,
            'for_recurring' => $this->for_recurring,
        ]);

        $this->resetForm();
        session()->flash('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->type = $category->type;
        $this->for_recurring = $category->for_recurring;
        $this->editing = true;
    }

    public function update()
    {
        $this->validate();

        Category::where('id', $this->categoryId)
            ->where('user_id', auth()->id())
            ->update([
                'name' => $this->name,
                'type' => $this->type,
                'for_recurring' => $this->for_recurring,
            ]);

        $this->resetForm();
        session()->flash('message', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);

        if ($category->transaksis()->exists()) {
            session()->flash('message', 'Kategori tidak bisa dihapus karena sedang digunakan.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'Pengeluaran';
        $this->for_recurring = false;
        $this->categoryId = null;
        $this->editing = false;
    }

    public function render()
    {
        $categories = Category::where('user_id', auth()->id())->orderBy('type')->get();
        return view('livewire.category-manager', compact('categories'));
    }
}
