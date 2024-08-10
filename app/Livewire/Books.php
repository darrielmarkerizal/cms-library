<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithFileUploads;

class Books extends Component
{
    use WithFileUploads;

    public $books;
    public $title, $description, $quantity, $category_id, $cover_image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'quantity' => 'required|integer',
        'category_id' => 'required|integer',
        'cover_image' => 'required|image|max:1024', 
    ];

    public function mount()
    {
        $this->books = Book::where('user_id', auth()->id())->get();
    }

    public function addBook()
    {
        $this->validate();

        $coverPath = $this->cover_image->store('covers', 'public');

        Book::create([
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'cover_image' => $coverPath,
            'user_id' => auth()->id(),
        ]);

        $this->resetInputFields();
        $this->books = Book::where('user_id', auth()->id())->get();
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->quantity = '';
        $this->category_id = '';
        $this->cover_image = '';
    }

    public function render()
    {
        return view('livewire.books');
    }
}