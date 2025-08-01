<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Progress
        </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-8">
        {{-- TOTAL PROGRESS --}}
        <div>
            <h3 class="text-lg font-bold mb-2">Overall Progress</h3>
            <p class="mb-1">{{ $knownQuestions }}/{{ $totalQuestions }} known ({{ $overallPercentage }}%)</p>
            <div class="w-full bg-gray-200 rounded h-4 overflow-hidden">
                <div class="bg-blue-600 h-4" style="width: {{ $overallPercentage }}%"></div>
            </div>
        </div>

        {{-- CATEGORY PROGRESS --}}
        @foreach ($categoryProgress as $category => $progress)
            <div>
                <h3 class="text-lg font-semibold mb-2">{{ $category }} Progress</h3>
                <p class="mb-1">{{ $progress['known'] }}/{{ $progress['total'] }} known ({{ $progress['percentage'] }}%)</p>
                <div class="w-full bg-gray-200 rounded h-4 overflow-hidden">
                    <div class="bg-green-500 h-4" style="width: {{ $progress['percentage'] }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
