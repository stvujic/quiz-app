<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if ($status === 'all')
                All Questions
            @elseif ($status === 'know')
                Questions I Know
            @elseif ($status === 'dont_know')
                Questions I Don’t Know
            @endif
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($questions->isEmpty())
                <p>No questions found for this category.</p>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Question</th>
                            <th class="px-4 py-2 text-left">Category</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($questions as $question)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $question->text }}</td>
                                <td class="px-4 py-2">{{ $question->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                                    <a href="#" class="text-green-600 hover:underline">Status</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
