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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <a href="{{ route('questions.status', 'all') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
            <h3 class="text-xl font-semibold text-center">All Questions</h3>
        </a>
        <a href="{{ route('questions.status', 'know') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-green-100">
            <h3 class="text-xl font-semibold text-center">I Know</h3>
        </a>
        <a href="{{ route('questions.status', 'dont_know') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-red-100">
            <h3 class="text-xl font-semibold text-center">I Don’t Know</h3>
        </a>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('test.categories') }}" style="display:inline-block; background-color:#007BFF; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px; margin-bottom: 15px;">

        Start Test
        </a>

        @if (Auth::user() && Auth::user()->is_admin)
            <br>
            <a href="{{ route('questions.create') }}" style="display:inline-block; background-color:#333; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px;">
                Add New Question
            </a>
        @endif
    </div>

</x-app-layout>
