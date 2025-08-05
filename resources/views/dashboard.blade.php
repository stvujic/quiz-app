<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #333;">
            Your Progress
        </h2>
    </x-slot>

    <style>
        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
            height: 20px;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            width: 0;
            transition: width 0.6s ease;
        }

        .blue-fill {
            background-color: #007bff;
        }

        .green-fill {
            background-color: #28a745;
        }

        .card {
            display: block;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.2s ease;
        }

        .card:hover {
            background-color: #f8f9fa;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media(min-width: 768px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .admin-btn {
            background-color: #333;
        }

        .csv-btn {
            background-color: #17a2b8;
            margin-top: 10px;
        }
    </style>

    <div style="padding: 20px; max-width: 800px; margin: 0 auto;">
        {{-- TOTAL PROGRESS --}}
        <div>
            <h3 style="font-size: 18px; font-weight: bold;">Overall Progress</h3>
            <p>{{ $knownQuestions }}/{{ $totalQuestions }} known ({{ $overallPercentage }}%)</p>
            <div class="progress-bar">
                <div class="progress-fill blue-fill" style="width: {{ (int)$overallPercentage }}%;"></div>
            </div>
        </div>

        {{-- CATEGORY PROGRESS --}}
        @foreach ($categoryProgress as $category => $progress)
            <div>
                <h3 style="font-size: 16px; font-weight: bold;">{{ $category }} Progress</h3>
                <p>{{ $progress['known'] }}/{{ $progress['total'] }} known ({{ $progress['percentage'] }}%)</p>
                <div class="progress-bar">
                    <div class="progress-fill green-fill" style="width: {{ (int)$progress['percentage'] }}%;"></div>
                </div>
            </div>
        @endforeach

        <div class="grid" style="margin-top: 40px;">
            <a href="{{ route('questions.status', 'all') }}" class="card">All Questions</a>
            <a href="{{ route('questions.status', 'know') }}" class="card" style="background-color: #d4edda;">I Know</a>
            <a href="{{ route('questions.status', 'dont_know') }}" class="card" style="background-color: #f8d7da;">I Don’t Know</a>
        </div>

        <div style="text-align: center;">
            {{-- DODATO: Dugme za CSV backup --}}
            <a href="{{ route('questions.export.csv') }}" class="button csv-btn">⬇ Backup Questions (CSV)</a><br>

            <a href="{{ route('test.categories') }}" class="button">Start Test</a><br>

            @if (Auth::user() && Auth::user()->is_admin)
                <a href="{{ route('questions.create') }}" class="button admin-btn">Add New Question</a>
            @endif
        </div>
    </div>
</x-app-layout>
