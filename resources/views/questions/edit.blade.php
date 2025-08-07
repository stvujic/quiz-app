<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Question</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('questions.update', $question->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Question Text</label>
                    <textarea name="text" rows="4" class="w-full border-gray-300 rounded-md resize-y">{{ old('text', $question->text) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Answer</label>
                    <textarea name="answer" rows="6" class="w-full border-gray-300 rounded-md resize-y">{{ old('answer', $question->answer) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Category</label>
                    <select name="category_id" class="w-full border-gray-300 rounded-md">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $question->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" style="padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                        Update Question
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
