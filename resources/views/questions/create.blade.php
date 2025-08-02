<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Add New Question
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">
        <form action="{{ route('questions.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Question Text --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Question</label>
                <input type="text" name="text" class="w-full mt-1 border-gray-300 rounded shadow-sm" required>
            </div>

            {{-- Answer --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Answer</label>
                <input type="text" name="answer" class="w-full mt-1 border-gray-300 rounded shadow-sm" required>
            </div>

            {{-- Category --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Category</label>
                <select name="category_id" class="w-full mt-1 border-gray-300 rounded shadow-sm" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Question
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
