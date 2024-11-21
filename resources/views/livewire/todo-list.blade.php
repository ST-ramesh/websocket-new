<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo-List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="to-do-container">
                        <div class="to-do-header">
                            <form wire:submit.prevent="createTodo" class="mb-4">
                                <input type="text" wire:model="content" id="todoContent" class="border rounded p-2" placeholder="Enter a To-Do item" />
                                @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2" style="background-color: #000; color:#fff">Add To-Do</button>
                            </form>
                    
                            <ul class="to-do-list">
                                @foreach($todos as $todo)
                                    <li class="to-do-item"><input type="checkbox" class="to-do-check">{{ $todo->content }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <script>
        document.addEventListener('livewire:load', () => {
            Echo.channel('todos')
                .listen('TodoCreated', (event) => {
                    console.log('Broadcast received:', event.todo); // Debug
                    Livewire.emit('todoAdded', event.todo); // Emit an event to Livewire
                });
        });
    </script>
</div>