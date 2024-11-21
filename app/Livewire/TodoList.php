<?php

namespace App\Livewire;

use App\Events\TodoCreated;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TodoList extends Component
{
    public $content;
    public $todos = [];

    public function mount()
    {
        $this->todos = Todo::all(); // Load existing todos
        Log::info('Mount todos:', $this->todos->toArray()); // Debug
    }

    #[On('echo:todos, TodoCreated')]
    public function createTodo()
    {
        $this->validate([
            'content' => 'required|string|max:255',
        ]);

        $todo = Todo::create(['content' => $this->content]);

        // Dispatch the event with the new Todo
        TodoCreated::dispatch($todo);

        $this->todos->prepend($todo); // Add the new Todo to the list
        $this->content = ''; // Clear the input field
    }


    public function todoAdded($todo)
    {
        Log::info('Received todo:', (array) $todo); 
        $this->todos->prepend($todo);
    }

    public function render()
    {
        Log::info('Rendering todos:', $this->todos->toArray());
        return view('livewire.todo-list')->layout('layouts.app');
    }
}
